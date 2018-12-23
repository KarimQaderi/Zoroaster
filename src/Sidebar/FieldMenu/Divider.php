<?php

    namespace KarimQaderi\Zoroaster\Sidebar\FieldMenu;


    use KarimQaderi\Zoroaster\Zoroaster;


    class Divider
    {

        public $component = 'view';



        public static function make()
        {
            return new static();
        }



        public function Render($item)
        {
            return Zoroaster::viewRender(view('Zoroaster::sidebar.Divider'));
        }

    }