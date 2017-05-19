<?php

namespace App\Services;

use App\Constants;
use App\Models\User;
use App\Models\PartnerFinance;
use App\Models\PartnerTransaction;
use App\Models\ExchangeRate;
use App\Services\ClientFinanceService;


final class PartnerFinanceService
{
    /* Начисляет комиссию партнеру за использование платных услуг */
    public static function chargePartnersComission($user_id, $girl_id, $type, $present_id = null)
    {
        $partner_id = User::where('id', '=', $girl_id)->first()->partner_id;
        if($partner_id !== 1){
            $price = ClientFinanceService::getServicePrice($type, $present_id);
            $acc_rate = self::getChargeRate($type);
            $exchange_rate_usd = (double)ExchangeRate::where('name', '=', 'lc_usd')->first()->rate;
            $accrual = $price*$acc_rate*$exchange_rate_usd;

            /* Увеличиваем баланс на счету партнера на сумму начисления */
            $partner_finances = PartnerFinance::where('partner_id', '=', $partner_id)->first();
            $partner_finances->amount = (double)$partner_finances->amount + $accrual;
            $partner_finances->save();

            /* Создаем запись о зачислении средств партнеру */
            $new_partner_trans = new PartnerTransaction();
            $new_partner_trans->user_id = $user_id;
            $new_partner_trans->girl_id = $girl_id;
            $new_partner_trans->amount = $accrual;
            $new_partner_trans->type = $type;
            $new_partner_trans->description = null;
            if ($present_id !== null) {
                $new_partner_trans->description = ClientFinanceService::getPresentName($present_id);
            }
            $new_partner_trans->partner_id = $partner_id;

            $new_partner_trans->save();
        }
    }
    /* Возвращает комиссию партнера (в частях единицы) в зависимости от типа услуги */
    public static function getChargeRate($type)
    {
        if ($type == 'gift') {
            $charge_rate = (double)ExchangeRate::where('name', '=', 'acc_gift')->first()->rate;
        } else {
            $charge_rate = (double)ExchangeRate::where('name', '=', 'acc_service')->first()->rate;
        }
        return $charge_rate;
    }
    /* Начисляет штраф или выплату партнеру которые создаются вручную из админки,
    *  создает запись о транзвакции, обновляет баланс партнера */
    public static function savePartnerFinancesChange($partner_id, $type, $sign, $amount, $description)
    {
        /* Обновляем баланс на счету партнера */
        $partner_finances = PartnerFinance::where('partner_id', '=', $partner_id)->first();

        /* $sign определяет, приводит ли транзакция к увеличению баланса или уменьшению */
        if ($sign === '+') {
            $partner_finances->amount = (double)$partner_finances->amount + $amount;
        } elseif ($sign === '-') {
            $partner_finances->amount = (double)$partner_finances->amount - $amount;
        } else {
            \Session::flash('flash_error', 'Ошибка: отсуствует параметр - знак транзакции. Не удалось обновить баланс');
        }
        $partner_finances->save();

        /* Создаем запись о транзакции */
        $new_partner_trans = new PartnerTransaction();
        $new_partner_trans->partner_id = $partner_id;
        $new_partner_trans->amount = $amount;
        $new_partner_trans->type = $type;
        $new_partner_trans->description = $description;
        $new_partner_trans->save();
    }
}