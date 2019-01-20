<?php

    namespace KarimQaderi\Zoroaster\Sidebar\FieldMenu;


    use KarimQaderi\Zoroaster\Zoroaster;
    use phpDocumentor\Reflection\Types\Integer;

    class MenuItem
    {

        public $component = 'MenuItem';


        public $TypeLink = null;
        public $Link = null;
        public $Label = null;
        public $data = null;
        public $icon = null;
        public $canSee = null;
        public $badge = null;


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

            $this->Link = $urlkey;

            $this->canSee = Zoroaster::resourceFindByUriKey($urlkey);

            if($label == null)
                if(!is_null($this->canSee))
                    $this->Label = $this->canSee->label;
                else
                    $this->Label = 'Resource پیدا نشد لطفا بررسی کنید';
            else
                $this->Label = $label;

            return $this;
        }

        public function route($route , $label)
        {
            $this->TypeLink = 'route';
            $this->Link =$route;
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
            $this->Link = $action;
            $this->Label = $label;
            return $this;
        }

        public function gate($gate_name)
        {
            $this->canSee = function() use ($gate_name){
                auth()->user()->can($gate_name);
            };
            return $this;

        }

        public function canSee($canSee)
        {
            $this->canSee = $canSee;
            return $this;
        }

        /**
         * @param Integer $badge
         * @return $this
         */
        public function badge($badge)
        {
            $this->badge = $badge;
            return $this;
        }

        public function AddSumItem($subItem)
        {
            $this->data = $subItem;
            return $this;
        }


        public function Render(MenuItem $item)
        {
            switch($item->TypeLink){
                case 'resource';
                    if(!$item->canSee->authorizedToIndex($item->canSee->newModel())) return null;
                    $item->Link = route("Zoroaster.resource.index" , ['resource' => $item->Link]);
                    break;
                case 'action';
                    $item->Link = action($item->Link);
                    break;
                    case 'route';
                    $item->Link =  route($item->Link);
                    break;

            }

            if(is_callable($item->canSee) && call_user_func($item->canSee)) return null;

            return view('Zoroaster::sidebar.MenuItem')->with([
                'item' => $item
            ]);
        }


    }