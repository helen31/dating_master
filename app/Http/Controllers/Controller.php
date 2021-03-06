<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $pages = DB::table('pages')->select('pages.id', 'slug', 'title')
            ->join('pages_translations', 'pages.id', '=', 'pages_translations.pages_id')
            ->where('pages_translations.locale', '=', App::getLocale())
            ->get();

        view()->share('pages', $pages); //pages links at all front
        
    }

    /** Admin tickets */
    /**
     * @return mixed
     */
    public static function getUnreadMessages()
    {
        return \App\Models\Ticket::unread();
    }

    /**
     * @param null $name
     * @return mixed
     */
    public static function getConfig($name = null){
        return \DB::table('options')->select('value')->where('name','=',$name)->get()[0]->value;
    }

    /**
     * @param null $name
     * @param null $value
     * @return bool
     */
    public static function setConfig($name = null, $value = null){
        DB::table('options') ->where('name', $name)
            ->update(['value' => $value]);
        
        return true;
    }

    /**
     * @return mixed
     */
    public static function getUnreadMessagesCount()
    {
        return \App\Models\Ticket::unreadCount();
    }

    /** Contact form */

    /**
     * @return mixed
     */
    public static function getContactMessages()
    {
        return \App\Models\ContacMessages::unread();
    }

    /**
     * @return mixed
     */
    public static function getContactUnread()
    {
        return \App\Models\ContacMessages::unreadCount();
    }

    /**
     * Remove email address, phone number, links from message
     *
     * @param $message string
     * @return mixed string
     */
    public static function robot($message)
    {
        $email_pattern = '/[^@\s]*@[^@\s]*\.[^@\s]*/';
        $links_pattern = '/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i';

        $phone_pattern = [
            '!(\b\+?[0-9()\[\]./ -]{7,17}\b|\b\+?[0-9()\[\]./ -]{7,17}\s+(extension|x|#|-|code|ext)\s+[0-9]{1,6})!i',
        ];

        $replace = ' **[removed]** ';

        $message = preg_replace($email_pattern, $replace, $message);
        $message = preg_replace($links_pattern, $replace, $message);

        foreach ($phone_pattern as $p){
            $message = preg_replace($p, $replace, $message);
        }

        return $message;
    }

    
    /**
     * Upload file to storage
     * Если нужно поместить файл во внутреннюю папку, например в uploads/albums/,
     * нужно указать $folder = 'albums/'
     *
     * @param object $file
     * @return string $name
     */
    public function upload($file, $folder='')
    {
        $name = time()."-".$file->getClientOriginalName();
        $destination = public_path().'/uploads/'.$folder;
        $file->move($destination, $name);

        return $name;
    }

    /**
     * Remove file from storage
     *
     * @param $file string
     * @return bool
     */
    public function removeFile($file)
    {
        if (file_exists($file)) {
            return unlink($file);
        } else {
            return;
        }
    }


    /** Users */
    //todo: move function to User model
    public function getUsers($roleId)
    {
        return User::select(['id', 'first_name', 'avatar', 'webcam'])
            ->where('role_id', '=', $roleId)
            ->where('status_id', '=', 1)
            ->paginate(20);
    }

    /**
     * Support method for db requests on users
     *
     * @return int
     */
    public function getRole()
    {
        if( \Auth::user() && \Auth::user()->hasRole('female') )
            return 4;
        else
            return 5;
    }
    /**
     * Transliteration
     *
     * @param $string
     * @return mixed
     */
    private function rus2translit($string)
    {
        $converter = [
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        ];

        return strtr($string, $converter);
    }
    /*
     * Методы для финансовых отчетов в админке
     */
    /* Возвращает из запроса начальную дату или устанавливает ее по умолчанию */
    public function getStartDate($request)
    {
        if ($request->has('start_date')) {
            $start_date = $request['start_date'];
        } else {
            $start_date = Carbon::now()->subDay(30)->toDateString();
        }
        return $start_date;
    }
    /* Возвращает из запроса конечную дату или устанавливает ее по умолчанию */
    public function getEndDate($request)
    {
        if ($request->has('end_date')) {
            $end_date = $request['end_date'];
        } else {
            $end_date = Carbon::now()->addDays(2)->toDateString();
        }
        return $end_date;
    }
    /* Получает общую сумму по выбранным транзкациям */
    public function getTransactionsAmount($transactions)
    {
        $amount = 0.00;
        foreach ($transactions as $trans) {
            $amount = $amount + (double)$trans->amount;
        }
        return $amount;
    }
}
