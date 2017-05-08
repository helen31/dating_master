<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ServicesPrice;
use App\Models\Horoscope;
use App\Models\HoroscopeTranslate;
use Illuminate\Http\Request;

use App\Services\ZodiacSignService;
use App\Services\ClientFinanceService;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

use App\Http\Requests;
use App\Constants;

class HoroscopeController extends Controller
{
    public function show($id, $cor_id){

        $id = \Auth::user()->id;
        /* Получение данных мужчины и женщины, а также вычисление знаков зодиака */
        $man = User::select('users.first_name', 'users.avatar', 'profile.birthday')
            ->leftJoin('profile', 'profile.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->first();
        $man->sign = ZodiacSignService::getSignByBirthday($man->birthday);
        $girl = User::select('users.first_name', 'users.avatar', 'profile.birthday')
            ->leftJoin('profile', 'profile.user_id', '=', 'users.id')
            ->where('users.id', '=', $cor_id)
            ->first();
        $girl->sign = ZodiacSignService::getSignByBirthday($girl->birthday);

        // Получаем стоимость услуги "Совместимость по гороскопу" для отображения на кнопке
        $horoscope_price = ServicesPrice::where('name', '=', Constants::EXP_HOROSCOPE)->first()->price;

        $type = Constants::EXP_HOROSCOPE;
        $know_horoscope = ClientFinanceService::isServiceActive($id, $cor_id, $type);

        if($know_horoscope == true){
            /* Получение id знаков зодиака мужчины и женщины */
            $man_sign_array = DB::table('hdate')->where('name', '=', $man->sign)->first();
            $man_sign_id = $man_sign_array->id;

            $girl_sign_array = DB::table('hdate')->where('name', '=', $girl->sign)->first();
            $girl_sign_id = $girl_sign_array->id;

            /* Получение id записи о совместимости */
            $compare_id = DB::table('hcompare')
                ->where('primary', '=', $man_sign_id)
                ->where('secondary', '=', $girl_sign_id)
                ->orWhere('primary', '=', $girl_sign_id)
                ->where('secondary', '=', $man_sign_id)
                ->first();

            /* Получение записи о совместимости по id */
            $compare = DB::table('htranslate')
                ->where('compare', '=', $compare_id->id)
                ->where('locale', '=', App::getLocale())
                ->first();
        }else{
            $compare = null;
        }

        return view('client.profile.horoscope')->with([
            'id'  => $id,
            'cor_id' => $cor_id,
            'man' => $man,
            'girl' => $girl,
            'compare' => $compare,
            'horoscope_price' => $horoscope_price,
        ]);
    }
    public function check($id, $cor_id){

        $type = Constants::EXP_HOROSCOPE;
        $is_access = ClientFinanceService::spendLoveCoins($cor_id, $type);
        if($is_access == true){
            return redirect('profile/'.$id.'/horoscope/'.$cor_id);
        }else{
            \Session::flash('alert-danger', trans('finance.no_money_no_honey'));
            return redirect('profile/'.$id.'/finance');
        }
    }

}
