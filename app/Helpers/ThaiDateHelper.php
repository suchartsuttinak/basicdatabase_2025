<?php

namespace App\Helpers;

use Carbon\Carbon;

class ThaiDateHelper
{
    /**
     * แสดงวันที่แบบเต็ม เช่น "12 ธันวาคม 2568"
     */
    public static function formatThaiDate($date)
    {
        Carbon::setLocale('th');
        $carbon = Carbon::parse($date);
        $day = $carbon->day;
        $month = $carbon->translatedFormat('F'); // เดือนภาษาไทย
        $year = $carbon->year + 543;

        return "{$day} {$month} {$year}";
    }

    /**
     * แสดงวันที่แบบย่อ เช่น "12/12/2568"
     */
    public static function formatThaiShort($date)
    {
        $carbon = Carbon::parse($date);
        $day = $carbon->format('d');
        $month = $carbon->format('m');
        $year = $carbon->year + 543;

        return "{$day}/{$month}/{$year}";
    }
}
