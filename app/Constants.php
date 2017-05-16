<?php
/*
 * Created by PhpStorm.
 * User: Oleh Hrebeniuk
 * Date: 08.08.2016
 * Time: 22:09
 */

namespace App;
class Constants
{
    /* Paid Services */
    const EXP_MESSAGE = 'message';
    const EXP_CHAT = 'chat';
    const EXP_VIDEO_CHAT = 'video';
    const EXP_ALBUM = 'photo_album';
    const EXP_GIRL_VIDEO = 'girl_video';
    const EXP_REQUEST_PHONE = 'request_phone';
    const EXP_REQUEST_EMAIL = 'request_email';
    const EXP_HOROSCOPE = 'horoscope';
    const EXP_GIFT = 'gift';

    /* Список всех платных услуг */
    private static $expenses = [
        'message', 'chat', 'video', 'photo_album',
        'girl_video', 'request_phone',
        'request_email', 'horoscope', 'gift'
    ];
    /*
    * Список услуг, начисление комиссии партнерам за которые происходит сразу, после оплаты
    * (например начисление комиссии за подарок происходит после подтверждения доставки подарка,
    * а начисление комиссии за сообщение - после ответа партнера на него)
    */
    private static $expenses_instant_charge = [
        'photo_album', 'girl_video', 'request_phone',
        'request_email', 'horoscope'
    ];


    /*
     * @return array
     */
    public static  function getExpTypes()
    {
        return self::$expenses;
    }

    public static  function getExpInstantChargeTypes()
    {
        return self::$expenses_instant_charge;
    }

}