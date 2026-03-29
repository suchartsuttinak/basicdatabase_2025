<?php

namespace App\Helpers;

use Carbon\Carbon;

class ThaiDateHelper
{
    public static function formatThaiDate($date)
    {
        if (empty($date)) return '-';

        try {
            Carbon::setLocale('th');
            $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);

            $day = $carbon->day;
            $month = $carbon->translatedFormat('F');
            $year = $carbon->year + 543;

            return "{$day} {$month} {$year}";
        } catch (\Exception $e) {
            return '-';
        }
    }

    public static function formatThaiShort($date)
    {
        if (empty($date)) return '-';

        try {
            $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);

            $day = $carbon->format('d');
            $month = $carbon->format('m');
            $year = $carbon->year + 543;

            return "{$day}/{$month}/{$year}";
        } catch (\Exception $e) {
            return '-';
        }
    }

   public static function toInputDate($date)
{
    if (empty($date)) return '';

    try {
        $carbon = $date instanceof \Carbon\Carbon ? $date : \Carbon\Carbon::parse($date);
        return $carbon->format('Y-m-d');
    } catch (\Exception $e) {
        return '';
    }
}
}