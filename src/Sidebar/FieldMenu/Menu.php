<?php

    namespace KarimQaderi\Zoroaster\Sidebar\FieldMenu;


    use Illuminate\Http\Resources\MergeValue;
    use KarimQaderi\Zoroaster\Zoroaster;
    use phpDocumentor\Reflection\Types\Boolean;

    class Menu extends MergeValue
    {

        public $component = 'Menu';
        public $canSee = true;



        public static function make($fields)
        {
            return new static($fields);
        }

        public function canSee(boolean $canSee)
        {
            $this->canSee = $canSee;

            return $this;
        }

        public function Render($item)
        {
            return view('Zoroaster::sidebar.Menu')->with([
                'item' => $item
            ]);
        }

    }