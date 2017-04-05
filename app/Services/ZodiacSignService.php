<?php
/**
 * Created by PhpStorm.
 * User: Oleh Hrebeniuk
 * Date: 16.08.2016
 * Time: 22:01
 */

namespace App\Services;


final class ZodiacSignService
{
    /**
     * @var array
     */
    private static $signs = [
        355 => 'Capricorn',
        325 => 'Sagittarius',
        295 => 'Scorpio',
        265 => 'Libra',
        232 => 'Virgo',
        202 => 'Leo',
        171 => 'Cancer',
        140 => 'Gemini',
        109 => 'Taurus',
        78  => 'Aries',
        49  => 'Pisces',
        19  => 'Aquarius',
        0   => 'Capricorn',


    ];


    public static function getSignByBirthday($date = '')
    {
        $sign = '';

        if (!$date) $date = new \DateTime();

        $dayOfYear = date('z', strtotime($date));
        $isLeapYear = date('L', strtotime($date));

        if ($isLeapYear && ($dayOfYear > 59)) {
            $dayOfYear -= 1;
        }

        foreach (self::$signs as $day => $sign) {
            if ($dayOfYear > $day) break;
        }

        return $sign;
    }
    public static function getAll(){
        $list=self::$signs;
        unset($list[0]);
        return $list;
    }
}