<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\ServicesPrice;
use App\Models\User;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Constants;
use Illuminate\Support\Facades\Auth;

/**
 * Class ExpenseController
 */
class ExpenseController extends Controller
{
    private $service;

    public function __construct(ExpenseService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }
}
