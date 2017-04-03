<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\Lists;
use DB;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class MessagesFromManController extends Controller
{
    /**
     * @var
     */
    private $expenseService;
    private $message;

    public function __construct(ExpenseService $expenseService, Messages $message)
    {
        $this->expenseService = $expenseService;
        $this->message = $message;

        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }
/*
 *
 *
 */
    public function index(){

        $heading = trans('mail.messages_from_men');

        $user_id = Auth::user()->id;

        //Получаем всех девушек, привлеченных партнером (их id в виде массива)
        //Это нужно для показа партнеру переписки только с теми мужчинами, которые пишут их девушкам
        $girls_raw = DB::table('users')->where('partner_id', '=', $user_id)->select('id')->get();
        $girls_array = [];
        foreach($girls_raw as $a){
            $girls_array[] = $a->id;
        }

        //Получаем список входящих сообщений от мужчин
        if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')){
            $income = Messages::join('users', 'users.id', '=', 'messages.from_user')
                ->where('users.role_id', '=', 4)
                ->select('messages.*', 'users.first_name', 'users.avatar', 'users.role_id')
                ->orderBy('messages.created_at', 'DESC')
                ->paginate(50);
        }elseif(Auth::user()->hasRole('Partner')){
            $income = Messages::join('users', 'users.id', '=', 'messages.from_user')
                ->where('users.role_id', '=', 4)
                ->whereIn('messages.to_user', $girls_array)
                ->select('messages.*', 'users.first_name', 'users.avatar', 'users.role_id')
                ->orderBy('messages.created_at', 'DESC')
                ->paginate(50);
        }else{
            abort(404);
        }

        // Количество непрочитанных входящих сообщений от мужчин
        $unread_income_count = $income->where('status', '=', 0)->count();

        return view('admin.mail.mail')->with([
            'girls' => $girls_array,
            'heading'=> $heading,
            'income' => $income,
            'unread_income_count' => $unread_income_count,
        ]);
    }
    /*
     * Вывод переписки с конкретным пользователем (входящих и исходящих сообщений)
     */
    public function show($id, $cor_id){

        $heading = trans('mail.write_message');

        //Получаем данные девушки и ее партнера
        $girl = User::where('id', '=', $cor_id)->first();

        // Получаем список входящих и исходящий сообщений между пользователями $id и $cor_id
        $messages = $this->message->where('messages.to_user', '=', $id)
            ->where('messages.from_user', '=', $cor_id)
            ->orWhere('messages.to_user', '=', $cor_id)
            ->where('messages.from_user', '=', $id)
            ->join('users', 'users.id', '=', 'messages.from_user')
            ->select('messages.*', 'users.first_name', 'users.avatar', 'users.role_id')
            ->orderBy('messages.created_at', 'DESC')
            ->paginate(25);

        return view('admin.mail.mail_show')->with([
            'heading'  => $heading,
            'girl'    => $girl,
            'man_id'  => $id,
            'girl_id'   => $cor_id,
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'sent_message' => 'required',
        ]);

        // Получаем список входящих непрочитанных сообщений от пользователя-мужчины
        // И присваиваем каждому сообщению статус "прочитанное"
        // Это происходит при отправке ответа, чтобы админ/модератор/партнер могли просмотреть переписку,
        // но сообщения при этом не помечались как прочитанные, а уже когда админы отправят ответ,
        // все непрочитанные сообщения от данного мужчины помечаются как прочитанные
        $unread_messages = $this->message->where('from_user', '=', $request->input('to_user'))
            ->where('to_user', '=', $request->input('from_user'))
            ->where('status', '=', 0) // Статус - непрочитанное
            ->get();
        foreach($unread_messages as $message){
            $message->status = 1; // Статус - прочитанное
            $message->save();
        }

        //Сохраняем новое сообщение в базе
        $message = new Messages();
        $message->from_user = $request->input('from_user');
        $message->to_user = $request->input('to_user');
        $message->message = $this->robot($request->input('sent_message'));
        $message->status = 0;
        $message->save();

        return redirect('admin/messages-from-man/'.$message->to_user.'/correspond/'.$message->from_user);
    }
}
