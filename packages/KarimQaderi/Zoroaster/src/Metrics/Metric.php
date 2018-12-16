<?php

    namespace KarimQaderi\Zoroaster\Metrics;


    abstract class Metric
    {
        /**
         * The displayable name of the metric.
         *
         * @var string
         */
        public $label;


        /**
         * Get the URI key for the metric.
         *
         * @return string
         */
        public function label()
        {
            if(is_null($this->label))
                $this->label = class_basename($this);

            return $this->label;
        }


        public function canSee()
        {
            return true;
        }

        public function render($metrics)
        {
            return view('Zoroaster::metrics.body')->with(array_merge((array)$metrics->calculate(request()) , [
                'class' => str_replace('\\' , '-' , get_class($metrics)) ,
                'ranges' => method_exists($metrics , 'ranges') ? $metrics->ranges() : null ,
            ]));
        }


    }
