<?php

    namespace KarimQaderi\Zoroaster\Sidebar\FieldMenu;


    use Illuminate\Http\Resources\MergeValue;
    use KarimQaderi\Zoroaster\Zoroaster;
    use phpDocumentor\Reflection\Types\Boolean;

    class Menu extends MergeValue
    {




        public static function make($fields)
        {
            return new static($fields);
        }

        public function Access(boolean $Access)
        {
            $this->Access = $Access;

            return $this;
        }

        public function Render($item)
        {
            return Zoroaster::viewRender(view('Zoroaster::sidebar.Menu')->with([
                'item' => $item
            ]));
        }

    }