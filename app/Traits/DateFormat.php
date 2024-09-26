<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateFormat
{
    public function custom_date_format($date, $format = 'd-m-Y') 
    {
        return Carbon::parse($date)->format($format);
    }
}
