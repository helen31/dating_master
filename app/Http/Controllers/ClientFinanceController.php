<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Finance;
use App\Models\ServicesPrice;
use App\Models\ExchangeRate;
use App\Constants;
use App\Http\Requests;

class ClientFinanceController extends Controller
{
    public function show($id)
    {
        $user_id = \Auth::user()->id;

        //Получаем баланс клиента
        $finances = '0.00';
        $account_data = Finance::where('user_id', '=', $user_id)->first();
        if($account_data != null){
            $finances = $account_data->amount;
        }
        //Получаем курсы обмена Love Coins к USD и EUR
        $lc_usd = (double)ExchangeRate::where('name', '=', 'lc_usd')->first()->rate;
        $lc_eur = (double)ExchangeRate::where('name', '=', 'lc_eur')->first()->rate;

        //Получаем список транзакций клиента
        $transactions = Transaction::where('user_id', '=', $user_id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('client.profile.finance')->with([
            'user_id' => $user_id,
            'finances' => $finances,
            'lc_usd' => $lc_usd,
            'lc_eur' => $lc_eur,
            'transactions' => $transactions,
        ]);
    }
}
