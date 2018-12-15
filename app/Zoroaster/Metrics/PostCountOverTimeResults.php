<?php

namespace App\Zoroaster\Metrics;

use App\models\CategoriePivot;
use App\models\Post;
use Illuminate\Http\Request;
use KarimQaderi\Zoroaster\Metrics\Partition;

class PostCountOverTimeResults extends Partition
{

    public $label = 'تعداد پست ها با جزئیات';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Post::class,'user_id');
    }


}
