<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Expenses;
use App\Models\Finance;
use App\Models\ServicesPrice;

use App\Constants;
use App\Http\Requests;

class ClientFinanceController extends Controller
{
    public function show($id){
        return view('client.profile.finance')->with([

        ]);
    }
}
