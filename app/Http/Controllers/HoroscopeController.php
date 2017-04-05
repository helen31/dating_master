<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Horoscope;
use App\Models\HoroscopeTranslate;
use Illuminate\Http\Request;
use App\Services\ZodiacSignService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

use App\Http\Requests;

class HoroscopeController extends Controller
{
    public function show($id, $cor_id){

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

        return view('client.profile.horoscope')->with([
            'id'  => $id,
            'cor_id' => $cor_id,
            'man' => $man,
            'girl' => $girl,
        ]);
    }
    public function check($id, $cor_id){

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

        return view('client.profile.horoscope')->with([
            'man' => $man,
            'girl' => $girl,
            'compare' => $compare,
        ]);
    }

}
