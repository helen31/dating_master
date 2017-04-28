<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Guzzle\Http\Client;
use Illuminate\Http\Request;

use App\Constants;
use App\Models\User;
use App\Models\ServicesPrice;
use App\Models\Finance;

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ClientFinanceController;

use App\Services\ClientFinanceService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Carbon\Carbon;

use App\Http\Requests;

class ContactsRequestController extends Controller
{

    /* Вывод страницы для на которой можно получить контактные данные девушек */
    public function showGirlContacts($id, $girl_id){

        $user_id = \Auth::user()->id;

        $type_phone = Constants::EXP_REQUEST_PHONE;
        $type_email = Constants::EXP_REQUEST_EMAIL;

        $know_phone = ClientFinanceService::isServiceActive($user_id, $girl_id, $type_phone);
        $know_email = ClientFinanceService::isServiceActive($user_id, $girl_id, $type_email);

        /* Получаем "открытые" данные девушки */
        $girl = User::select('users.*', 'profile.birthday')
            ->leftJoin('profile', 'profile.user_id', '=', 'users.id')
            ->where('users.id', '=', $girl_id)
            ->first();

        return view('client.profile.contacts_request')->with([
            'id'  => $id,
            'girl_id' => $girl_id,
            'girl' => $girl,
            'know_phone' => $know_phone,
            'know_email' => $know_email,
        ]);
    }

    /* Получение имени, фамилии и телефона девушки */
    public function getGirlPhone($id, $girl_id){

        $type = Constants::EXP_REQUEST_PHONE;
        $is_access = ClientFinanceService::spendLoveCoins($girl_id, $type);
        if($is_access == true){
            return redirect('profile/'.$id.'/contacts/'.$girl_id);
        }else{
            \Session::flash('alert-danger', trans('finance.no_money_no_honey'));
            return redirect('profile/'.$id.'/finance');
        }

    }

    /* Получение имени, фамилии и е-мейла девушки */
    public function getGirlEmail($id, $girl_id){

        $type = Constants::EXP_REQUEST_EMAIL;
        $is_access = ClientFinanceService::spendLoveCoins($girl_id, $type);
        if($is_access == true){
            return redirect('profile/'.$id.'/contacts/'.$girl_id);
        }else{
            \Session::flash('alert-danger', trans('finance.no_money_no_honey'));
            return redirect('profile/'.$id.'/finance');
        }
    }
}
