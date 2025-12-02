<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaybookBalance extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function report_date()
    {
        $day_blance = DaybookBalance::latest('id')->value('date');
        $day_Summary = DaybookSummary::latest('id')->value('date');

        if ($day_blance == $day_Summary) {
            $date = \Carbon\Carbon::parse($day_blance)->addDay()->toDateString();
        } else {
            $date = $day_blance;
        }

        return $date;
    }
}
