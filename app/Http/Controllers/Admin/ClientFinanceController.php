<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Constants;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Finance;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Models\PartnerFinance;
use App\Models\PartnerTransaction;
use App\Services\ClientFinanceService;

class ClientFinanceController extends Controller
{
    /* Класс для вывода отчетов по клиентах в Love Coins */
    public function __construct()
    {
        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }
    /* Выводит отчет по пополнению счетов клиентов */
    public function getDeposits(Request $request)
    {
        $start_date = $this->getStartDate($request);
        $end_date = $this->getEndDate($request);

        $transactions = Transaction::leftJoin('users', 'users.id' ,'=', 'transactions.user_id')
            ->where('transactions.type', '=', 'deposit')
            ->whereBetween('transactions.created_at', [$start_date, $end_date])
            ->select('transactions.*', 'users.first_name', 'users.last_name')
            ->get();

        $amount = $this->getTransactionsAmount($transactions);

        return view('admin.finances.clients.deposits')->with([
            'heading' => 'Отчет по пополнению кредитов клиентами (Love Coins)',
            'transactions' => $transactions,
            'amount' => $amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
    /* Выводит отчет по тратам клиентов */
    public function getExpenses(Request $request)
    {
        $start_date = $this->getStartDate($request);
        $end_date = $this->getEndDate($request);

        $transactions = Transaction::leftJoin('users', 'users.id' ,'=', 'transactions.user_id')
            ->whereIn('transactions.type', Constants::getExpTypes())
            ->whereBetween('transactions.created_at', [$start_date, $end_date])
            ->select('transactions.*', 'users.first_name', 'users.last_name')
            ->get();

        $amount = $this->getTransactionsAmount($transactions);

        return view('admin.finances.clients.expenses')->with([
            'heading' => 'Отчет по потраченным кредитам (Love Coins)',
            'transactions' => $transactions,
            'amount' => $amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
    /* Выводит отчет по возвратам средств клиентам */
    public function getRefunds(Request $request)
    {
        $start_date = $this->getStartDate($request);
        $end_date = $this->getEndDate($request);

        $transactions = Transaction::leftJoin('users', 'users.id' ,'=', 'transactions.user_id')
            ->where('transactions.type', '=', 'refund')
            ->whereBetween('transactions.created_at', [$start_date, $end_date])
            ->select('transactions.*', 'users.first_name', 'users.last_name')
            ->get();

        $amount = $this->getTransactionsAmount($transactions);

        return view('admin.finances.clients.refunds')->with([
            'heading' => 'Отчет по возврату средств клиентам (Love Coins)',
            'transactions' => $transactions,
            'amount' => $amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
    /* Выводит общую статистику по клиентам (суммы остатков на счетах) */
    public function getGeneralStat()
    {
        $finances = Finance::leftJoin('users', 'users.id' ,'=', 'finances.user_id')
            ->orderBy('finances.amount', 'DESC')
            ->select('finances.*', 'users.first_name', 'users.last_name')
            ->get();

        $amount = 0.00;
        foreach ($finances as $fin) {
            $amount = $amount + (double)$fin->amount;
        }

        return view('admin.finances.clients.general-stat')->with([
            'heading' => 'Общая статистика по клиентам (Love Coins)',
            'finances' => $finances,
            'amount' => $amount,
        ]);
    }
    /* Выводит детальную финансовую статистику по выбранному клиенту */
    public function getDetailStat(Request $request, $user_id)
    {
        $start_date = $this->getStartDate($request);
        $end_date = $this->getEndDate($request);

        $user = User::where('id', '=', $user_id)->first();

        $amount = Finance::where('user_id', '=', $user_id)->first()->amount;

        $transactions = Transaction::where('user_id', '=', $user_id)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $deposits = Transaction::where('user_id', '=', $user_id)
            ->where('type', '=', 'deposit')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $expenses = Transaction::where('user_id', '=', $user_id)
            ->whereIn('type', Constants::getExpTypes())
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $refunds = Transaction::where('user_id', '=', $user_id)
            ->where('type', '=', 'refund')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $deposits_amount = $this->getTransactionsAmount($deposits);
        $expenses_amount = $this->getTransactionsAmount($expenses);
        $refunds_amount = $this->getTransactionsAmount($refunds);

        return view('admin.finances.clients.detail-stat')->with([
            'heading' => 'Детальная статистика по клиенту (Love Coins)',
            'user'    => $user,
            'transactions' => $transactions,
            'amount' => $amount,
            'deposits_amount' => $deposits_amount,
            'expenses_amount' => $expenses_amount,
            'refunds_amount' => $refunds_amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
    /* Выводит форму для создания начисления / возврата средств клиенту */
    public function getRefundForm($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        $amount = Finance::where('user_id', '=', $user_id)->first()->amount;

        return view('admin.finances.clients.refund')->with([
            'heading' => 'Начислить / вернуть средства клиенту (Love Coins)',
            'user' => $user,
            'amount' => $amount,
        ]);
    }
    /* Выводит форму для создания списания / штрафа клиенту */
    public function getDebitForm($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        $amount = Finance::where('user_id', '=', $user_id)->first()->amount;

        return view('admin.finances.clients.debit')->with([
            'heading' => 'Списать средства с клиента (Love Coins)',
            'user' => $user,
            'amount' => $amount,
        ]);
    }
    /* Создает и сохраняет запись о произведенном возврате / зачислении, обновляет баланс клиента */
    public function saveRefund(Request $request, $user_id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
        ]);
        $type = 'refund';
        $sign = '+';
        $amount = $request->input('amount');
        if ($request->has('description')) {
            $description = $request->input('description');
        } else {
            $description = null;
        }
        ClientFinanceService::saveClientFinancesChange($user_id, $type, $sign, $amount, $description);

        \Session::flash('flash_success', 'Данные успешно сохранены');
        return redirect('admin/finance/clients/detail-stat/'.$user_id);
    }
    /* Создает и сохраняет запись о наложеннои штрафе, обновляет баланс партнера */
    public function saveDebit(Request $request, $user_id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
        ]);
        $type = 'debit';
        $sign = '-';
        $amount = $request->input('amount');
        if ($request->has('description')) {
            $description = $request->input('description');
        } else {
            $description = null;
        }
        ClientFinanceService::saveClientFinancesChange($user_id, $type, $sign, $amount, $description);

        \Session::flash('flash_success', 'Данные успешно сохранены');
        return redirect('admin/finance/clients/detail-stat/'.$user_id);
    }
}
