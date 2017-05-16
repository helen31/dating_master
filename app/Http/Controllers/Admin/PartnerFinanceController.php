<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Constants;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

use App\Models\PartnerFinance;
use App\Models\PartnerTransaction;

class PartnerFinanceController extends Controller
{
    /* Класс для вывода отчетов по партнерам в USD */
    public function __construct()
    {
        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }
    /* Выводит общую статистику по партнерам (суммы задолженности на счетах) */
    public function getGeneralStat()
    {
        $partner_finances = PartnerFinance::leftJoin('users', 'users.id' ,'=', 'partner_finances.partner_id')
            ->where('partner_finances.partner_id', '!=', 1) // этот человек - Admin
            ->orderBy('partner_finances.amount', 'DESC')
            ->select('partner_finances.*', 'users.first_name', 'users.last_name')
            ->get();

        $amount = 0.00;
        foreach ($partner_finances as $pfin) {
            $amount = $amount + (double)$pfin->amount;
        }

        return view('admin.finances.partners.general-stat')->with([
            'heading' => 'Общая статистика по партнерам (USD)',
            'partner_finances' => $partner_finances,
            'amount' => $amount,
        ]);
    }
    /* Выводит детальную статистику по выбранному партнеру (начисления, выплаты, штрафы) */
    public function getDetailStat(Request $request, $partner_id){

        $start_date = $this->getStartDate($request);
        $end_date = $this->getEndDate($request);

        $partner = User::where('id', '=', $partner_id)->first();

        $amount = PartnerFinance::where('partner_id', '=', $partner_id)->first()->amount;

        $transactions = PartnerTransaction::where('partner_id', '=', $partner_id)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $payments = PartnerTransaction::where('partner_id', '=', $partner_id)
            ->where('type', '=', 'payment')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $accruals = PartnerTransaction::where('partner_id', '=', $partner_id)
            ->whereIn('type', Constants::getExpTypes())
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $fines = PartnerTransaction::where('partner_id', '=', $partner_id)
            ->where('type', '=', 'fine')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')
            ->get();

        $payments_amount = $this->getTransactionsAmount($payments);
        $accruals_amount = $this->getTransactionsAmount($accruals);
        $fines_amount = $this->getTransactionsAmount($fines);

        return view('admin.finances.partners.detail-stat')->with([
            'heading' => 'Детальная статистика по партнеру (USD)',
            'partner'    => $partner,
            'transactions' => $transactions,
            'amount' => $amount,
            'payments_amount' => $payments_amount,
            'accruals_amount' => $accruals_amount,
            'fines_amount' => $fines_amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
    /* Выводит отчет по штрафам, наложенным партнерам */
    public function getFines(Request $request)
    {
        $id = \Auth::user()->id;

        $start_date = $this->getStartDate($request);
        $end_date = $this->getEndDate($request);

        if (\Auth::user()->hasRole('Owner')) {
            $transactions = PartnerTransaction::leftJoin('users', 'users.id' ,'=', 'partner_transactions.partner_id')
                ->where('partner_transactions.type', '=', 'fine')
                ->where('partner_finances.partner_id', '!=', 1) // партнер с id = 1 - это админ
                ->whereBetween('partner_transactions.created_at', [$start_date, $end_date])
                ->select('partner_transactions.*', 'users.first_name', 'users.last_name')
                ->get();
        } elseif (\Auth::user()->hasRole('Partner')) {
            $transactions = PartnerTransaction::leftJoin('users', 'users.id' ,'=', 'partner_transactions.partner_id')
                ->where('partner_transactions.type', '=', 'fine')
                ->where('partner_transactions.partner_id', '=', $id)
                ->whereBetween('partner_transactions.created_at', [$start_date, $end_date])
                ->select('partner_transactions.*', 'users.first_name', 'users.last_name')
                ->get();
        } else {
            abort(404);
        }

        $amount = $this->getTransactionsAmount($transactions);

        return view('admin.finances.clients.fines')->with([
            'heading' => 'Штрафы по партнерам (USD)',
            'transactions' => $transactions,
            'amount' => $amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
    /* Выводит форму для создания выплаты партнеру */
    public function getPartnerPaymentForm()
    {

    }
    /* Выводит форму для создания штрафа партнеру */
    public function getPartnerFineForm()
    {

    }
    /* Создает и сохраняет запись о произведенном платеже, обновляет баланс партнера */
    public function savePartnerPayment()
    {

    }
    /* Создает и сохраняет запись о наложеннои штрафе, обновляет баланс партнера */
    public function savePartnerFine()
    {

    }
}
