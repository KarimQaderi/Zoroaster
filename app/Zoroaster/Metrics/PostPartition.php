<?php

    namespace App\Zoroaster\Metrics;

    use App\models\Post;
    use Illuminate\Http\Request;
    use KarimQaderi\Zoroaster\Metrics\Partition;

    class PostPartition extends Partition
    {

        public $label = 'تعداد پست ها با جزئیات';

        /**
         * Calculate the value of the metric.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return mixed
         */
        public function calculate(Request $request)
        {
            return $this->count($request , Post::class , 'user_id')->label(function($label)
            {
                switch($label)
                {
                    case 1:
                        return 'کریم قادری';
                        break;
                    default:
                        return $label;
                        break;
                }

            });
        }


    }
