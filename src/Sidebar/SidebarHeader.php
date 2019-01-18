<?php

    namespace KarimQaderi\Zoroaster\Sidebar;


    use KarimQaderi\Zoroaster\Zoroaster;

    class SidebarHeader
    {
        public $component = 'view';

        public static function make()
        {
            return new static();
        }


        public function Render($item)
        {
            return view('Zoroaster::sidebar.SidebarHeader');
        }
    }