<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicesPrice;

use App\Http\Requests;

class PriceController extends Controller
{
    public function index()
    {
        $prices = ServicesPrice::all();

        return view('client.price')->with([
            'prices' => $prices,
        ]);
    }
}
