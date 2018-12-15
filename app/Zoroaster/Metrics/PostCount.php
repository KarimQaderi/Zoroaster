<?php

namespace App\Zoroaster\Metrics;

use App\models\Post;
use Illuminate\Http\Request;
use KarimQaderi\Zoroaster\Metrics\Value;

class PostCount extends Value
{

    public $label ="تعدا پست";

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Post::Class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            1 => '1 Days',
            30 => '30 Days',
            60 => '60 Days',
            365 => '365 Days',
        ];
    }


}
