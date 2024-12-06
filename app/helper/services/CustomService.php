<?php

namespace App\helper\services;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class CustomService
{
    protected $data;
    public function __construct()
    {

    }

    public function changDate($date)
    {
        function convertPtoE($string) {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            $output= str_replace($persian, $english, $string);
            return $output;
        }
        $new_date = convertPtoE($date);

        $new_date = explode('/', $new_date);
        $new_date = (new Jalalian((int)$new_date[0], (int)$new_date[1], (int)$new_date[2]))->toCarbon()->toDateTimeString();

        return $new_date;
    }

    public function reDate($date)
    {
        function convertEtoP2($string) {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            $output= str_replace($english, $persian, $string);
            return $output;
        }
//        $new_date = convertEtoP($date);

//
//        $new_date =  \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($date));
//        $new_date = explode('-', $new_date);
//        $new_date = (new Jalalian((int)$new_date[0], (int)$new_date[1], (int)$new_date[2]))->toDateString();
        $new_date = $date;


//        $new_date = explode('/', $new_date);
//        $new_date = (new Jalalian((int)$new_date[0], (int)$new_date[1], (int)$new_date[2]))->toCarbon()->toDateTimeString();

        return $new_date;
    }

    public function reDateP($date)
    {
        function convertEtoP($string) {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            $output= str_replace($english, $persian, $string);
            return $output;
        }
//        $new_date = convertEtoP($date);


        $new_date =  \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($date));
        $new_date = explode('-', $new_date);
        $new_date = (new Jalalian((int)$new_date[0], (int)$new_date[1], (int)$new_date[2]))->toDateString();
        $new_date = convertEtoP($new_date);


//        $new_date = explode('/', $new_date);
//        $new_date = (new Jalalian((int)$new_date[0], (int)$new_date[1], (int)$new_date[2]))->toCarbon()->toDateTimeString();

        return $new_date;
    }

}
