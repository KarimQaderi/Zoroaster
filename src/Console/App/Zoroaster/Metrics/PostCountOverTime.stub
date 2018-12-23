<?php

namespace App\Zoroaster\Metrics;

use App\models\Post;
use Illuminate\Http\Request;
use KarimQaderi\Zoroaster\Metrics\Trend;

class PostCountOverTime extends Trend
{

    public $label = 'تعداد پست ها در طول زمان';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays($request, Post::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            15 => '15 Days',
            30 => '30 Days',
            60 => '60 Days',
            90 => '90 Days',
        ];
    }

}
