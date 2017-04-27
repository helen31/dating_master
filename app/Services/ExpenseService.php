<?php

namespace App\Services;

use App\Models\Expenses;
use App\Models\Finance;
use App\Models\ServicesPrice;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class ExpenseService
 * @package App\Services
 *
 */
class ExpenseService
{
    /**
     * @var Expenses
     */
    private $expense;

    /**
     * ExpenseService constructor.
     * @param Expenses $expenses
     */
    public function __construct(Expenses $expenses)
    {
        $this->expense = $expenses;
    }

    /* Если не пригодится - удали этот класс */
}