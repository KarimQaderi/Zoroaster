<?php

    namespace KarimQaderi\Zoroaster\Sidebar\FieldMenu;


    use KarimQaderi\Zoroaster\Exceptions\NotFoundResource;
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
        /* @var $canSee \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource */
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

        public function resource($urlkeyOrResourceClass , $label = null)
        {
            $this->TypeLink = 'resource';


            $this->canSee = Zoroaster::resourceFindByUriKey($urlkeyOrResourceClass);
            $this->Link = $urlkeyOrResourceClass;
            $this->Label = $label;

            if(is_null($this->canSee) && class_exists($urlkeyOrResourceClass)){
                $this->canSee = new $urlkeyOrResourceClass;
                if(!method_exists($this->canSee , 'uriKey'))
                    Throw  (new NotFoundResource())->setResource($urlkeyOrResourceClass);

                $this->Link = $this->canSee->uriKey();
            }

            if(!is_null($this->canSee))
                $this->Label = $this->canSee->label;


            return $this;
        }

        public function route($route , $label)
        {
            $this->TypeLink = 'route';
            $this->Link = $route;
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
                return auth()->user()->can($gate_name);
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
            if(is_bool($item->canSee) && $item->canSee == false) return null;
            if(is_callable($item->canSee) && call_user_func($item->canSee) == false) return null;

            switch($item->TypeLink){
                case 'resource';
                    if(is_null($this->canSee))
                        throw new \Exception("Resource Not Found [$this->Link]");

                    if(!$item->canSee->authorizedToIndex($item->canSee->newModel())) return null;
                    $item->Link = route("Zoroaster.resource.index" , ['resource' => $item->Link]);
                    break;

                case 'action';
                    $item->Link = action($item->Link);
                    break;

                case 'route';
                    $item->Link = route($item->Link);
                    break;
            }

            return view('Zoroaster::sidebar.MenuItem')->with([
                'item' => $item
            ]);
        }


    }