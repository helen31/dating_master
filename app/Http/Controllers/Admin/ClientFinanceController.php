<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Transaction;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClientFinanceController extends Controller
{

    public function __construct()
    {
        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }
    public function getDeposits(Request $request)
    {
        if ($request->has('end_date_time') && $request->has('start_date_time')) {
            $end_date_time = $request['end_date_time'];
            $start_date_time = $request['start_date_time'];
        } else {
            $end_date_time = Carbon::now();
            $start_date_time = $end_date_time->subDay(30);
        }
        $deposits = Transaction::where('type', '=', 'deposit')->get();

        $amount = 0.00;
        foreach ($deposits as $deposit) {
            $amount = $amount + (double)$deposit->amount;
        }
        $date = Carbon::now()->toDateTimeString();

        return view('admin.finances.clients.deposits')->with([
            'heading' => 'Отчет по пополнению кредитов (Love Coins)',
            'deposits' => $deposits,
            'amount' => $amount,
            'end_date_time' => $end_date_time,
            'start_date_time' => $start_date_time,
            'date' => $date,
        ]);
    }
    public function getExpenses()
    {
        return view('admin.finances.clients.deposits')->with([
            'heading' => 'Отчет по потраченным кредитам (Love Coins)',
        ]);
    }
    public function getRefunds()
    {
        return view('admin.finances.clients.deposits')->with([
            'heading' => 'Отчет по возврату средств клиентам (Love Coins)',
        ]);
    }


}
