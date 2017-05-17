<?php

namespace App\Services;

use App\Models\Presents;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Finance;
use App\Services\PartnerFinanceService;
use App\Models\ServicesPrice;
use App\Constants;
use App\Http\Requests;

/*
 * Класс содержит служебные методы, которые относятся к транзакциям в виртуальной валюте Love Coins
 * - пополнение счетов клиентами
 * - расходы клиентов
 * - текущий баланс на счетах клиентов
 * - стоимость услуг
 */
final class ClientFinanceService
{
    /*
     * Алгоритм зачисления средств на баланс
     */
    public static function putLoveCoins()
    {
        //
    }
    /*
     * Алгоритм списания средств с баланса и создания записи о трате в таблице transactions
     * Принимает:
     * $girl_id - ID девушки
     * $type = тип услуги (таблица services_price, поле name)
     * Возвращает:
     * - true  - если услуга была оплачена и срок действия еще не истек
     *         - если услуга бессрочная или предоставляется бесплатно
     *         - если удалось списание необходимой суммы со счета пользователя
     * (в этих случаях услуга предоставляется)
     * - false - если у клиента-мужчины нет счета или недостаточно средств для оплаты услуги
     * (в этом случае необходимо вывести сообщение о необходимости оплаты счета)
     */
    public static function spendLoveCoins($girl_id, $type, $present_id = null)
    {
        $user_id = \Auth::user()->id;
        $girl_data = User::find($girl_id);

        /* Проверяем доступна ли услуга без оплаты. За отправку сообщения ('messages') нужно платить каждый раз,
        другие услуги имеют срок действия или активны постоянно после разовой оплаты */
        $active = self::isServiceActive($user_id, $girl_id, $type);

        /* Получаем дату истечения срока действия услуги */
        $expire = self::getDateTimeExpired($type);

        /* Получаем стоимость услуги */
        $price = self::getServicePrice($type, $present_id);

        /* Получаем баланс пользователя */
        $balance = self::getUserBalance($user_id);
        // Если пользователь - мужчина, а пользователь, который предосталяет услугу - женщина
        if (\Auth::user()->hasRole('Male') && $girl_data->role_id == 5) {
            //Проверка, оплачена ли услуга
            if ($active == true) {
                return true;
            } else {
                // Проверка, если ли на балансе нужная сумма
                if ($balance >= $price) {

                    //Списываем средства со счета клиента
                    $new_balance = Finance::where('user_id', '=', $user_id)->first();
                    $new_balance->amount = $balance - $price;
                    $new_balance->save();

                    //Создаем запись о списании
                    $new_transaction = new Transaction();
                    $new_transaction->user_id = $user_id;
                    $new_transaction->girl_id = $girl_id;
                    $new_transaction->amount = $price;
                    $new_transaction->type = $type;
                    $new_transaction->description = null;
                    if ($present_id !== null) {
                        $new_transaction->description = self::getPresentName($present_id);
                    }
                    $new_transaction->partner_id = $girl_data->partner_id;
                    $new_transaction->expire = $expire;

                    $new_transaction->save();

                    /* Если тип транзакции относится к тем, за которые сразу перечисляется комиссия
                    партнеру, начисляем эту комиссию */
                    if (in_array($type, Constants::getExpInstantChargeTypes())) {
                       PartnerFinanceService::chargePartnersComission($user_id, $girl_id, $type);
                    }
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return true;
        }
    }
    /*
     * Проверяет, была ни раньше оплачена данная услуга и не закончился ли срок ее действия.
     * Принимает:
     * $user_id = ID пользователя-мужчины
     * $girl_id = ID девушки
     * $type = тип услуги (таблица services_price, поле name)
     * Возвращает:
     * true, если услуга активна, а также для оплаченных услуг без срока действия
     * false - если срок действия услуги истек или она еще не оплачивалась раньше
     */
    public static function isServiceActive($user_id, $girl_id, $type)
    {

        $active = false;//Услуга по умолчанию недоступна

        //для части услуг $active всегда false
        if (!in_array($type, ['message', 'gift', 'deposit'])) {
            /* Получаем запись из transactions с переданными данными */
            $paid_service = Transaction::where('user_id', '=', $user_id)
                ->where('girl_id', '=', $girl_id)
                ->where('type', '=', $type)
                ->first();
            $now = Carbon::now()->toDateTimeString();
            if (isset($paid_service)) { // Если запись о заказе услуги существует
                if ($paid_service->expire == null || // Если услуга не имеет срока действия
                    $paid_service->expire > $now
                ) { // Или срок действия услуги еще не истек
                    $active = true;
                }
            }
        }
        return $active;
    }
    /*
     * Получает стоимость услуги
     * Принимает: тип услуги (таблица services_price, поле name)
     * Возвращает (double): стоимость услуги в Love Coins
     */
    public static function getServicePrice($type, $present_id = null)
    {
        if($present_id === null) {
            $price = (double)ServicesPrice::where('name', '=', $type)
                ->first()->price;
        } else {
            $price = (double)Presents::where('id', '=', $present_id)
                ->first()->price;
        }
        return $price;
    }
    /*
     * Получает баланс пользователя в Love Coins
     * Принимает: ID пользователя
     * Возвращает (double):
     * - сумму Love Coins на счету пользователя
     * - 0,00 если у пользователя нет счета
     */
    public static function getUserBalance($user_id)
    {
        if (isset(Finance::where('user_id', '=', $user_id)->first()->id)) {
            $balance = (double)Finance::where('user_id', '=', $user_id)
                ->first()->amount;
        } else {
            $balance = (double)0;
        }
        return $balance;
    }
    /*
     * Рассчитывает дату истечения срока действия услуги от текушего момента
     * Принимает: тип услуги (таблица services_price, поле name)
     * Возвращает:
     * - рассчетную дату окончания действия услуги (string)
     * - null, если услуга бессрочная или ее срок действия рассчитывается другим методом
     */
    public static function getDateTimeExpired($type)
    {
        $expire = null;

        if (!in_array($type, ['message', 'gift', 'deposit'])) {
            $period_name = ServicesPrice::where('name', '=', $type)
                ->first()->term;

            switch ($period_name) {
                case 'day':
                    $expire = Carbon::now()->addDays(1)->toDateTimeString();
                    break;
                case 'week':
                    $expire = Carbon::now()->addDays(7)->toDateTimeString();
                    break;
                case 'month':
                    $expire = Carbon::now()->addDays(30)->toDateTimeString();
                    break;
                default:
                    $expire = null;
            }
        }
        return $expire;
    }
    /*
     * Получает дату истечения срока услуги из таблицы transactions
     * Возвращает полученную дату или null, если нужной записи не существует
     */
    public static function checkDateTimeExpired($user_id, $girl_id, $type)
    {
        $expire_date = null;
        $paid_service = Transaction::where('user_id', '=', $user_id)
            ->where('girl_id', '=', $girl_id)
            ->where('type', '=', $type)
            ->first();
        if(isset($paid_service)){
            $expire_date = $paid_service->expire;
        }
        return $expire_date;
    }
    /*
     * Возвращает имя подарка по id на языке выбранной локали.
     * Или null, если подарок с данным ID не существует
     */
    public static function getPresentName($present_id)
    {
        $present_name = Presents::join('presents_translations', 'presents.id', '=', 'presents_translations.present_id')
            ->select('presents_translations.title as title')
            ->where('presents.deleted_at', '=', null)
            ->where('presents.id', '=', $present_id)
            ->where('presents_translations.locale', \App::getLocale())
            ->first();
        if($present_name !== null){
            return $present_name->title;
        }
        return null;
    }
    /* Начисляет штраф или возврад средств клиенту, которые создаются вручную из админки,
    *  создает запись о транзвакции, обновляет баланс клиента */
    public static function saveClientFinancesChange($user_id, $type, $sign, $amount, $description)
    {
        /* Обновляем баланс на счету партнера */
        $finances = Finance::where('user_id', '=', $user_id)->first();

        /* $sign определяет, приводит ли транзакция к увеличению баланса или уменьшению */
        if ($sign === '+') {
            $finances->amount = (double)$finances->amount + $amount;
        } elseif ($sign === '-') {
            $finances->amount = (double)$finances->amount - $amount;
        } else {
            \Session::flash('flash_error', 'Ошибка: отсуствует параметр - знак транзакции. Не удалось обновить баланс');
        }
        $finances->save();

        /* Создаем запись о транзакции */
        $new_trans = new Transaction();
        $new_trans->user_id = $user_id;
        $new_trans->amount = $amount;
        $new_trans->type = $type;
        $new_trans->description = $description;
        $new_trans->save();
    }

}
