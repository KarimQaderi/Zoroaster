<?php

    namespace KarimQaderi\Zoroaster\Sidebar\FieldMenu;


    use KarimQaderi\Zoroaster\Zoroaster;
    use phpDocumentor\Reflection\Types\Boolean;

    class MenuItem
    {

        public $component = 'MenuItem';


        public $TypeLink = null;
        public $Link = null;
        public $Label = null;
        public $data = null;
        public $icon = null;
        public $canSee = null;

        public function __construct(...$arguments)
        {
        }

        public static function make()
        {
            return new static();
        }

        public function icon($icon)
        {
            $this->icon = $icon;
            return $this;
        }

        public function resource($urlkey , $label = null)
        {
            $this->TypeLink = 'resource';
            $this->Link = route("Zoroaster.resource.index" , ['resource' => $urlkey]);

            $newResource = Zoroaster::resourceFindByUriKey($urlkey);

            if($label == null)
                if(!is_null($newResource))
                    $this->Label = $newResource->labels;
                else
                    $this->Label = 'Resource پیدا نشد لطفا بررسی کنید';
            else
                $this->Label = $label;

            if(!is_null($newResource))
                $this->canSee = $newResource->authorizedToIndex($newResource->newModel());

            return $this;
        }

        public function route($route , $label)
        {
            $this->TypeLink = 'route';
            $this->Link = route($route);
            $this->Label = $label;
            return $this;
        }

        public function link($link , $label)
        {
            $this->TypeLink = 'link';
            $this->Link = $link;
            $this->Label = $label;
            return $this;
        }

        public function action($action , $label)
        {
            $this->TypeLink = 'action';
            $this->Link = action($action);
            $this->Label = $label;
            return $this;
        }

        public function gate($gate_name)
        {
            $this->canSee = auth()->user()->can($gate_name);
            return $this;

        }

        public function canSee($canSee)
        {
            $this->canSee = call_user_func($canSee);
            return $this;
        }

        public function AddSumItem($subItem)
        {
            $this->data = $subItem;
            return $this;
        }


        public function Render($item)
        {
            return Zoroaster::viewRender(view('Zoroaster::sidebar.MenuItem')->with([
                'item' => $item
            ]));
        }


    }