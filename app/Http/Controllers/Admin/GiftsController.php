<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gifts;
use App\Models\GiftStatus;
use App\Models\Presents;
use App\Models\PresentsTranslation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GiftsController extends Controller
{
    private $present;
    private $pt;
    private $user;
    private $gift;

    public function __construct(Gifts $gift, Presents $present, User $user, PresentsTranslation $pt)
    {
        $this->middleware('auth');
        \Auth::user()->hasRole(['Owner', 'Moder', 'Partner']);

        $this->present = $present;
        $this->user = $user;
        $this->pt = $pt;
        $this->gift = $gift;

        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }

    /*
     * Получение списка заказов подарков в зависимости от статуса доставки
     * Админ и модератор видят все заказы
     * Партнер только свои (заказы для своих девушек)
     */
    public function getGiftsByStatus($status){

        $gift_status = GiftStatus::where('name', 'like', $status)->first();

        if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')){
            $gifts = Gifts::withTrashed()
                ->where('status_id', '=', $gift_status->id)
                ->join('presents_translations', 'gifts.present', '=', 'presents_translations.present_id')
                ->select('gifts.*', 'presents_translations.title')
                ->where('presents_translations.locale', \App::getLocale())
                ->paginate(15);
        }else{
            $girls = $this->user->where('partner_id', '=', Auth::user()->id)
                ->select('id')
                ->get();
            $gifts = Gifts::withTrashed()
                ->where('status_id', '=', $gift_status->id)
                ->whereIn('to', $girls)
                ->join('presents_translations', 'gifts.present', '=', 'presents_translations.present_id')
                ->select('gifts.*', 'presents_translations.title')
                ->where('presents_translations.locale', \App::getLocale())
                ->paginate(15);
        }

        return view('admin.gifts.status')->with([
            'heading' => 'Заказы подарков со статусом: '.trans('admin/sidebar-left.gifts_'.$status),
            'gifts'   => $gifts,
        ]);
    }

    public function edit($id)
    {
        $gift = Gifts::withTrashed()->where('id', '=', $id)->first();
        $statuses = GiftStatus::all();

        return view('admin.gifts.edit')->with([
            'heading' => 'Добавить фото подтверждения / редактировать статус',
            'gift' => $gift,
            'statuses' => $statuses,
        ]);
    }


    public function update(Request $request, $id)
    {
        $gift = Gifts::withTrashed()->find($id);

        if ($request->file('confirm_photo')) {
            $gift_file = time().'-'.$request->file('confirm_photo')->getClientOriginalName();
            $destination = public_path().'/uploads/confirm_photos/';
            $request->file('confirm_photo')->move($destination, $gift_file);

            $gift->confirm_photo = $gift_file;
        }

        if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')){
            $gift->status_id = $request->input('status_id'); // Статус доставки тот, который присвоен администратором
            $gift->status_message = NULL; // Сообщение касается только отклоненных заказов, поэтому оно обнуляется, если статус - не отклонен
            if($request->input('status_id') == 3){
                $gift->status_message = $request->input('status_message');
            }
        }else{
            $gift->status_id = 2; // Статус доставки после сохранинея партнером - на рассмотрении
        }

        $gift->save();

        \Session::flash('flash_success', 'Информация успешно обновлена');

        return redirect()->back();
    }



    public function drop($id)
    {
        $this->gift->find($id)->delete();

        \Session::flash('flash_success', 'Подарок удален');

        return redirect('/admin/gifts/status/on_confirmation');
    }






}
