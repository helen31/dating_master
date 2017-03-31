<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Horoscope;
use App\Models\HoroscopeTranslate;
use Illuminate\Http\Request;

use App\Http\Requests;

class HoroscopeController extends Controller
{
    public function show(){

        return view('client.profile.horoscope');
    }
}
