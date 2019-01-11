<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;


    class ID extends Field
    {
        use Resource;

        public $nameViewForm = 'text';


        public function __construct($label = null , $name = null )
        {
            parent::__construct($label ?? 'ID' , $name);
        }




    }
