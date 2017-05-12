<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\ServicesPrice;
use App\Models\ExchangeRate;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        \Auth::user()->hasRole(['Owner', 'Moder', 'Partner']);

        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }
    /*
     * Получает прайсы на платные услуги
     */
    public function getPrices()
    {
        $prices = ServicesPrice::all();

        return view('admin.prices.prices')->with([
            'heading'=> 'Прайсы на услуги',
            'prices' => $prices,
        ]);
    }
    /*
     * Получает обменные курсы и ставки комиссии партнерам за использование платных услуг клиентами
     */
    public function getRates()
    {
        $rates = ExchangeRate::all();

        return view('admin.prices.rates')->with([
            'heading'=> 'Курсы валют и комиссия партнерам',
            'rates' => $rates,
        ]);
    }
    /*
     * Устанавливает прайс на конкретную платную услугу
     */
    public function setPrice(Request $request)
    {
        $this->validate($request, [
            'service_id' => 'required',
            'price' => 'required | numeric',
        ]);
        $price = ServicesPrice::find($request->input('service_id'));
        $price->price = (float)$request->input('price');
        $price->save();

        \Session::flash('flash_success', 'Цена на услугу обновлена');

        return redirect('/admin/finance/prices');
    }
    /*
     * Устанавливает обменный курс или комиссию партнерам
     */
    public function setRate(Request $request)
    {

        $this->validate($request, [
            'rate_id' => 'required',
            'rate' => 'required | numeric',
        ]);
        $rate = ExchangeRate::find($request->input('rate_id'));
        $rate->rate = (float)$request->input('rate');
        $rate->save();

        \Session::flash('flash_success', 'Изменения успешно сохранены');

        return redirect('/admin/finance/rates');
    }

}
