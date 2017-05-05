<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gifts;
use App\Models\Presents;
use App\Services\ClientFinanceService;
use Carbon\Carbon;

class GiftsController extends Controller
{
    /*
     * Получение списка отправленных или полученных подарков
     * Мужчина видит отправленные женщинам подарки
     * Женщина видит заказанные мужчинами подарки
     */
    public function getGifts(){
        $role = Auth::user()->role_id;
        if($role == 4){      // Пользователь - мужчина
            $gifts = Gifts::withTrashed()
                ->where('from', '=', Auth::user()->id)
                ->join('presents_translations', 'gifts.present', '=', 'presents_translations.present_id')
                ->select('gifts.*', 'presents_translations.title')
                ->where('presents_translations.locale', \App::getLocale())
                ->paginate(10);

            return view('client.profile.gifts_sent')->with([
                'gifts'  => $gifts,
                'role'   => $role,
            ]);
        }else{               // Пользователь - женщина

            $gifts = Gifts::withTrashed()
                ->where('to', '=', Auth::user()->id)
                ->join('presents_translations', 'gifts.present', '=', 'presents_translations.present_id')
                ->select('gifts.*', 'presents_translations.title')
                ->where('presents_translations.locale', \App::getLocale())
                ->paginate(10);

            return view('client.profile.gifts_received')->with([
                'gifts' => $gifts,
                'role'  => $role,
            ]);
        }
    }
    /*
     * Получение каталога доступных подарков, в котором мужчина может выбрать подарок девушке
     * Также выводится информация о девушке, с профиля которой осуществляется заказ подарка
     */
    public function getPresents($id, $girl_id){

        $girl = User::where('id', '=', $girl_id)->first();

        $presents = Presents::join('presents_translations', 'presents.id', '=', 'presents_translations.present_id')
            ->select('presents.*', 'presents_translations.title', 'presents_translations.description')
            ->where('presents.deleted_at', '=', null)
            ->where('presents.partner_id', '=', 1)
            ->where('presents_translations.locale', \App::getLocale())
            ->orWhere('presents.partner_id', '=', $girl->partner_id)
            ->where('presents_translations.locale', \App::getLocale())
            ->orderBy('presents.partner_id', 'DESC')
            ->paginate(10);

        return view('client.profile.presents')->with([
            'id' => $id,
            'girl' => $girl,
            'presents' => $presents,
        ]);
    }
    /*
     * Форма подтверждения заказа подарка мужчиной
     * В форму выводится информация о девушке и выбранном подарке
     * А также можно добавить сообщение от мужчины
     */
    public function getOrderForm($id, $girl_id, $gift_id){

        $girl = User::where('id', '=', $girl_id)->first();
        $present = Presents::join('presents_translations', 'presents.id', '=', 'presents_translations.present_id')
            ->select('presents.*', 'presents_translations.title', 'presents_translations.description')
            ->where('presents.deleted_at', '=', null)
            ->where('presents.id', '=', $gift_id)
            ->where('presents_translations.locale', \App::getLocale())
            ->first();

        return view('client.profile.gift_order')->with([
            'id'   => $id,
            'girl' => $girl,
            'present' => $present,
        ]);
    }
    /*
     * Обрабатывает POST от формы подтверждения заказа
     * Сохраняет информацию о заказе
     * Возвращает список отправленных подарков
     */
    public function order(Request $request, $id){

        $type = 'gift';
        $present_id = $request->input('present');
        $is_access = ClientFinanceService::spendLoveCoins($request->input('to'), $type, $present_id);

        if($is_access === true){
            $gift = new Gifts();
            $gift->from = $request->input('from');
            $gift->to = $request->input('to');
            $gift->present = $request->input('present');
            $gift->status_id = 1;
            $gift->status_message = null;
            if($request->input('gift_message')){
                $gift->gift_message = $request->input('gift_message');
            }
            $gift->save();

            return redirect('profile/'.$id.'/gifts');
        }else{
            \Session::flash('alert-danger', trans('finance.no_money_no_honey'));
            return redirect('profile/'.$request->input('from').'/finance');
        }










    }
}
