<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Models\Transaction;
use App\Models\ServicesPrice;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\Lists;
use DB;

use App\Models\ChatContactList;
use App\Services\ClientFinanceService;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    /**
     * @var
     */
    private $message;

    public function __construct(Messages $message)
    {
        $this->message = $message;
        parent::__construct();
    }
/*
 * Выводит список всех сообщений по группам: входящие, исходящие,
 * входящие от фаворитов, входящие от черного списка
 */
    public function index($id){

        $user_id = \Auth::user()->id;

        // Получаем список пользователей, добавленных нашим пользователем в фавориты в виде массива
        $favorites_raw = DB::table('lists')->where('subject_id', '=', $user_id)
            ->where('list', '=', 1)->select('object_id')->get();
        $favourites_array = [];
        foreach($favorites_raw as $f){
            $favourites_array[] = $f->object_id;
        }

        // Получаем список пользователей, добавленных нашим пользователем в черный список
        $blacklist_raw = DB::table('lists')->where('subject_id', '=', $user_id)
           ->where('list', '=', 2)->select('object_id')->get();
        $blacklist_array = [];
        foreach($blacklist_raw as $b){
            $blacklist_array[] = $b->object_id;
        }

        // Получаем список входящих сообщений
        $income = Messages::where('messages.to_user', '=', $user_id)
            ->select('messages.*', 'users.first_name', 'users.avatar', 'users.role_id')
            ->join('users', 'users.id', '=', 'messages.from_user')
            ->whereNotIn('users.id', $blacklist_array) //Не показывать сообщения пользователей, входящих в черный список
            ->orderBy('messages.created_at', 'DESC')
            ->paginate(50);

        // Количество непрочитанных входящих сообщений
        $unread_income_count = $income->where('status', '=', 0)->count();


        // Получаем список исходящих сообщений
        $outcome = Messages::where('messages.from_user', '=', $user_id)
            ->select('messages.*', 'users.first_name', 'users.avatar')
            ->join('users', 'users.id', '=', 'messages.to_user')
            ->orderBy('messages.created_at', 'DESC')
            ->paginate(50);


        //Получаем список сообщений от фаворитов
        $favourites = Messages::where('messages.to_user', '=', $user_id)
            ->select('messages.*', 'users.first_name', 'users.avatar', 'users.role_id')
            ->join('users', 'users.id', '=', 'messages.from_user')
            ->whereIn('users.id', $favourites_array)
            ->orderBy('messages.created_at', 'DESC')
            ->paginate(50);

        // Количество непрочитанных сообщений от фаворитов
        $unread_favourites_count = $favourites->where('status', '=', 0)->count();


        //Получаем список сообщений от черного списка
        $blacklist = Messages::where('messages.to_user', '=', $user_id)
            ->select('messages.*', 'users.first_name', 'users.avatar', 'users.role_id')
            ->join('users', 'users.id', '=', 'messages.from_user')
            ->whereIn('users.id', $blacklist_array)
            ->orderBy('messages.created_at', 'DESC')
            ->paginate(50);

        return view('client.profile.mail')->with([
            'income' => $income,
            'unread_income_count' => $unread_income_count,
            'outcome' => $outcome,
            'favourites' => $favourites,
            'unread_favourites_count' => $unread_favourites_count,
            'blacklist' => $blacklist,
        ]);

    }
    /*
     * Вывод переписки с конкретным пользователем (входящих и исходящих сообщений)
     */
    public function show($id, $cor_id){

        $user_id = \Auth::user()->id;

        // Получаем имя и название файла фото собеседника для выведения в переписку
        $cor = User::where('id', '=', $cor_id)->select('first_name', 'avatar')->first();

        // Получаем список входящих и исходящий сообщений между пользователями $id и $cor_id
        $messages = $this->message->where('messages.to_user', '=', $id)
            ->where('messages.from_user', '=', $cor_id)
            ->orWhere('messages.to_user', '=', $cor_id)
            ->where('messages.from_user', '=', $id)
            ->join('users', 'users.id', '=', 'messages.from_user')
            ->select('messages.*', 'users.first_name', 'users.avatar', 'users.role_id')
            ->orderBy('messages.created_at', 'DESC')
            ->paginate(25);

        /* Проверяем, находиться ли корреспондент в фаворитах или черном списке пользователя
         * Это нужно для того, чтобы выводить кнопки, например "Добавить в фавориты" или "Удалить из фаворитов"
         * Переменные is_favourites и is_blacklist больше нуля, если корреспондент не находится в черном списке пользователя
         */
        $is_favourites = Lists::where('subject_id', '=', $id)
            ->where('object_id', '=', $cor_id)
            ->where('list', '=', 1) // Пользователь находится в списке фаворитов
            ->get()->count();

        $is_blacklist = Lists::where('subject_id', '=', $id)
            ->where('object_id', '=', $cor_id)
            ->where('list', '=', 2) // Пользователь находится в черном списке
            ->get()->count();


        // Получаем список входящих непрочитанных сообщений от пользователя
        // И присваиваем каждому сообщению статус "прочитанное"
        $unread_messages = $this->message->where('to_user', '=', $id)
            ->where('from_user', '=', $cor_id)
            ->where('status', '=', 0) // Статус - непрочитанное
            ->get();
        foreach($unread_messages as $message){
            $message->status = 1; // Статус - прочитанное
            $message->save();
        }

        return view('client.profile.mail_show')->with([
            'cor_id'  => $cor_id,
            'cor' => $cor,
            'user_id' => $user_id,
            'messages' => $messages,
            'is_favourites' => $is_favourites,
            'is_blacklist'  => $is_blacklist,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'sent_message' => 'required',
        ]);

        $type = Constants::EXP_MESSAGE;
        $is_access = ClientFinanceService::spendLoveCoins($request->input('to_user'), $type);

        if($is_access === true){
            $message = new Messages();
            $message->from_user = $request->input('from_user');
            $message->to_user = $request->input('to_user');
            $message->message = $this->robot($request->input('sent_message'));
            $message->status = 0;
            $message->save();

            return redirect('profile/'.$message->from_user.'/correspond/'.$message->to_user);
        }else{
            \Session::flash('alert-danger', trans('finance.no_money_no_honey'));
            return redirect('profile/'.$request->input('from_user').'/finance');
        }
    }
}
