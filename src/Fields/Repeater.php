<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;
    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Fields\Extend\FieldElement;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\Traits\Builder;

    /**
     * Class Repeater
     * @package KarimQaderi\Zoroaster\Fields
     */
    class Repeater extends FieldElement
    {
        use Builder;

        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'repeater';

        /**
         * @var string
         */
        public $nameViewForm = 'repeater';

        /**
         * @var array
         */
        public $fields = [];

        /**
         * @var string
         */
        public $label;

        /**
         * @var mixed|string|null
         */
        public $name;

        /**
         * @var Model null
         */
        public $model;


        /**
         * @var array
         */
        private $labelBtn;

        /**
         * @var $repeaterScript boolean | string | array
         */
        private $repeaterScript;


        /**
         * جدید فیلد ایجاد
         *
         * @param  string      $label
         * @param  string|null $name
         * @param Model null $model
         */
        public function __construct($label , $name , $model = null)
        {
            $this->label = $label;
            $this->name = $name ?? str_replace(' ' , '_' , Str::lower($label));
            $this->model = $model;

            $this->hideFromIndex();
        }

        /**
         * @param string $label
         *
         * @return $this
         */
        public function setLabelBtnAdd(string $label)
        {
            $this->labelBtn['add'] = $label;

            return $this;
        }

        /**
         * @param string $label
         *
         * @return $this
         */
        public function setLabelBtnRemove(string $label)
        {
            $this->labelBtn['remove'] = $label;

            return $this;
        }

        /**
         * @param $name
         * @param $default
         *
         * @return mixed
         */
        private function getLabel($name , $default)
        {
            return isset($this->labelBtn[$name]) ? $this->labelBtn[$name] : $default;
        }


        /**
         * @return $this
         */
        public function setParent()
        {
            $this->repeaterScript = true;

            return $this;
        }

        /**
         * @param  $repeaterScript boolean | string | array
         *
         * @return $this
         */
        public function setRepeaterScript($repeaterScript)
        {
            $this->repeaterScript = $repeaterScript;

            return $this;
        }

        /**
         * @param array $fields
         *
         * @return Repeater
         */
        public function fields(array $fields)
        {
            $this->fields = $fields;

            return $this;
        }


        /**
         * @param       $builder
         * @param array $data
         * @param       $resourceRequest
         *
         * @return string|string[]|null
         */
        private function renderTemplate($builder , $data = [] , $resourceRequest)
        {
            $render = "<template id='{$builder->name}_temp'><div data-repeater-item>";

            $render .= self::RenderForm($builder->fields , (object)$data , null , $resourceRequest);

            $render .= "<input class='btn uk-button uk-button-primary uk-border-rounded uk-margin-small-top' data-repeater-delete type='button' value='" . $this->getLabel('remove' , 'حذف') . "'/>";
            $render .= "<div class='btn uk-button uk-button-primary uk-border-rounded uk-margin-small-top' data-repeater-move uk-icon='move'></div>";

            $render .= "</div></template>";

            return preg_replace('#<script(.*?)>(.*?)</script>#is' , '' , $render);
        }

        /**
         * @param $builder
         * @param $datas
         * @param $resourceRequest
         *
         * @return string
         */
        private function render($builder , $datas , $resourceRequest)
        {

            $render = "<div class='{$builder->name}'>" . "<h3>$builder->label</h3>" . "<div data-repeater-list='{$builder->name}' uk-sortable='group: {$builder->name}'>";

            $renderView = function($builder , $data = []) use ($resourceRequest){

                $render = "<div data-repeater-item>";

                $render .= self::RenderForm($builder->fields , (object)$data , null , $resourceRequest);

                $render .= "<input class='btn uk-button uk-button-primary uk-border-rounded uk-margin-small-top' data-repeater-delete type='button' value='" . $this->getLabel('remove' , 'حذف') . "'/>";
                $render .= "<div class='btn uk-button uk-button-primary uk-border-rounded uk-margin-small-top' data-repeater-move uk-icon='move'></div>";

                $render .= "</div>";

                return $render;
            };


            foreach($datas as $data)
                $render .= $renderView($builder , $data);

            $render .= "</div><input class='btn uk-button uk-button-primary uk-border-rounded uk-margin-small-top' data-repeater-create type='button' value='" . $this->getLabel('add' , 'اضافه کردن') . "'></div>";

            return $render;
        }

        /**
         * @var
         */
        private $getRepeaterSelector;
        /**
         * @var
         */
        private $getRepeaterTemp;

        /**
         * @param       $builder
         * @param array $selector
         * @param       $resourceRequest
         *
         * @return mixed
         */
        private function getRepeaterSelector(&$builder , $selector = [] , $resourceRequest)
        {

            foreach($builder as $field)
            {

                if(isset($field->data))
                {
                    $this->getRepeaterSelector($field->data , $selector , $resourceRequest);
                }

                if($field instanceof Repeater)
                {

                    $field->setParent();

                    [ $this->getRepeaterSelector , $step ] = $this->addSubArray($this->getRepeaterSelector , $selector , [
                        'selector' => '.' . $field->name ,
                        'repeaters' => [] ,
                        'template' => '#' . $field->name . '_temp' ,
                        'show' => 'FunStartfunction(){
                         $(this).slideDown();
                         }FunEnd' ,
                        'hide' => 'FunStartfunction(deleteElement){
                        $this=this;
                        Confirm_delete(\'Delete\',function(){
                        $($this).slideUp(\'normal\', function() { $(this).remove(); } );
                        });
                        }FunEnd' ,
                    ]);

                    $this->getRepeaterTemp .= $this->renderTemplate($field , [] , $resourceRequest);

                    $this->getRepeaterSelector($field->fields , array_merge($selector , [ $step , 'repeaters' ]) , $resourceRequest);
                }

            }

            return $this->getRepeaterSelector;
        }


        /**
         * @param $array
         * @param $key
         * @param $value
         *
         * @return array
         */
        private function addSubArray($array , $key , $value)
        {
            $array_ref = &$array;

            foreach($key as $item)
            {
                $array_ref = &$array_ref[$item];
            }

            $array_ref[] = $value;
            $count = count($array_ref) - 1;
            if($count < 0)
            {
                $step = 0;
            }

            return [ $array , $count ];
        }


        /**
         * @param Field           $field
         * @param                 $data
         * @param resourceRequest $resourceRequest
         *
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewForm($builder , $resource , $resourceRequest = null)
        {
            try
            {

                if($old = old($builder->name))
                {
                    $data = $old;
                }
                else
                {
                    $data = isset($resource->{$builder->name}) ? $resource->{$builder->name} : [];
                }

                $this->getRepeaterSelector = [
                    'selector' => '.' . $builder->name ,
                    'repeaters' => [] ,
                    'template' => '#' . $builder->name . '_temp' ,
                    'show' => 'FunStartfunction(){
                    $(this).slideDown();
                     }FunEnd' ,
                    'hide' => 'FunStartfunction(deleteElement){
                    $this=this;
                    Confirm_delete(\'Delete\',function(){
                    $($this).slideUp(\'normal\', function() { $(this).remove(); } );
                    });
                    }FunEnd' ,
                ];


                $repeatersJS = $this->getRepeaterSelector($builder->fields , [ 'repeaters' ] , $resourceRequest);
                $repeatersJS = json_encode($repeatersJS);
                $repeatersJS = str_replace(PHP_EOL , '' , $repeatersJS);
                $repeatersJS = str_replace('\r' , '' , $repeatersJS);
                $repeatersJS = str_replace('\n' , '' , $repeatersJS);
                $repeatersJS = str_replace('"FunStart' , '' , $repeatersJS);
                $repeatersJS = str_replace('FunEnd"' , '' , $repeatersJS);

                return view('Zoroaster::fields.Form.repeater')->with([
                    'renderTemplate' => $this->renderTemplate($builder , [] , $resourceRequest) . $this->getRepeaterTemp ,
                    'name' => $builder->name ,
                    'id' => $builder->name . '_' . time() ,
                    'repeatersJS' => $repeatersJS ,
                    'render' => $this->render($builder , $data , $resourceRequest) ,
                    'repeaterScript' => $this->repeaterScript ,
                ]);

            } catch( \Exception $exception )
            {
                throw new \Exception($exception);
            }

        }

        /**
         * @param Field $field
         * @param       $data
         * @param null  $resourceRequest
         *
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewDetail($field , $data , $resourceRequest = null)
        {
            try
            {
                return view('Zoroaster::fields.Detail.' . $field->nameViewForm)->with(
                    [
                        'field' => $field ,
                        'data' => $data ,
                        'value' => $this->displayCallback($data , $resourceRequest , $field) ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch( \Exception $exception )
            {
                throw new \Exception($exception);
            }
        }

        /**
         * @param                 $field
         * @param                 $data
         * @param ResourceRequest $resourceRequest
         *
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewIndex($field , $data , $resourceRequest = null)
        {
            try
            {
                return view('Zoroaster::fields.Index.' . $field->nameViewForm)->with(
                    [
                        'field' => $field ,
                        'data' => $data ,
                        'value' => $this->displayCallback($data , $resourceRequest , $field) ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch( \Exception $exception )
            {
                throw new \Exception($exception);
            }
        }


        /**
         * @param $data
         * @param $resourceRequest
         * @param $field
         *
         * @return mixed
         */
        public function displayCallback($data , $resourceRequest , $field)
        {
            if(is_callable($field->displayCallback))
            {
                return call_user_func($field->displayCallback , $data , $resourceRequest , $field);
            }

            return data_get($data , $field->name);
        }


        /**
         * @param RequestField $requestField
         *
         * @return array
         */
        public function ResourceDestroy(RequestField $requestField)
        {
            return [
                'error' => [] ,
            ];
        }

        /**
         * @param RequestField $requestField
         *
         * @return array
         */
        public function beforeResourceStore(RequestField $requestField)
        {

            return [
                'error' => [] ,
                'data' => [] ,
            ];
        }

        /**
         * @param RequestField $requestField
         *
         * @return array
         */
        public function ResourceStore(RequestField $requestField)
        {
            return [
                'error' => [] ,
                'data' => [] ,
            ];

        }


        /**
         * @param RequestField $requestField
         *
         * @return array
         */
        public function ResourceUpdate(RequestField $requestField)
        {

            $model_id = $requestField->resource->{$requestField->resource->getKeyName()};

            $data = $this->traitResource_2($requestField->field , $requestField->field->name , null , $model_id);

//            dd(request());
            if(class_exists($requestField->field->model))
            {
                return [
                    'error' => null ,
                    'data' => [] ,
                ];
            }
            else
            {
                return [
                    'error' => null ,
                    'data' => [ $requestField->field->name => $data ] ,
                ];
            }

        }

        /**
         * @var array
         */
        private $traitResource = [];

        /**
         * @param      $builder
         * @param null $selector
         *
         * @return array
         */
        private function traitResource_2($builder , $selector = null , $is_array = false , $model_id = null)
        {

            $data = [];
            $models = [];
            $selectors = [];
            $lavel = 0;

            $fun = function($field , $selector){
                $data = [];
                $selectors = null;
                $models = null;
                if($field instanceof Repeater)
                {
                    if(class_exists($field->model))
                    {
                        $models = $field;
                        $selectors = $selector;
                    }
                    else // is_array
                    {
                        $data = [ $field->name => $this->traitResource_2($field , $selector , true) ];
//                        $data[] = [ $field->name => request($selector) ];
                    }
                }
                else
                {
                    $data = [ $field->name => request($selector) ];
                }

                return [ $data , $models , $selectors ];

            };

//            dd(count(request($selector)));
            $fields = $this->getOnlyField($builder->fields);
            for($i = 0; $i <= count($fields); $i++)
            {
                $data_2 = [];
                $models_2 = [];
                $selector_2 = [];
                foreach($fields as $field)
                {
                    $selector_get = $selector . ".{$i}." . $field->name;

                    $funData = $fun($field , $selector_get);
                    $data_2 = array_merge($data_2 , $funData[0]);
                    if(!is_null($funData[1]))
                    {
                        $models_2[] = $funData[1];
                    }
                    if(!is_null($funData[2]))
                    {
                        $selector_2[] = $funData[2];
                    }
                }
                $data[] = array_filter($data_2);
                $models[] = array_filter($models_2);
                $selectors[] = array_filter($selector_2);
            }


//            $selector .= ".{$lavel}." . $field->name;


            if($is_array)
            {
                return $data;
            }


            if(!class_exists($builder->model))
            {
                return $data;
            }


            for($i = 0; $i <= count($data) - 1; $i++)
            {
                dump([ 'post_id' => $model_id ] + $data[$i]);
                $model_id_2 = $builder->model::create([ 'post_id' => $model_id ] + $data[$i])->id;
                $j = 0;
                foreach($models as $model)
                {
                    foreach($model as $item)
                    {
                        dump($selectors[$i][$j]);
                        $this->traitResource_2($item , $selectors[$i][$j] , false , $model_id_2);
                    }
                }
            }


            dd('dd');
            dd($data);


        }

        /**
         * @param $builder
         *
         * @return array
         */
        private function getOnlyField($builder)
        {
            $Fields = [];
            foreach($builder as $field)
            {
                if(isset($field->data) && is_array($field->data) && count($field->data) != 0)
                {
                    $Fields = array_merge($Fields , $this->getOnlyField($field->data));
                }
                else
                {
                    $Fields [] = $field;
                }
            }

            return $Fields;
        }


        /**
         * @param      $builder
         * @param null $selector
         */
        private function traitResource($builder , $selector = null)
        {

            foreach($builder as $field)
            {

                if(isset($field->data))
                {
                    $this->traitResource($field->data , $selector);
                }

                if($field instanceof Repeater)
                {

                    $field->setParent();


                    if(is_null($selector))
                    {
                        $selector .= $field->name;
                    }
                    else
                    {
                        $selector .= '.*.' . $field->name;
                    }

                    dump($selector);


                    $this->traitResource['request'] = array_merge($this->traitResource['request'] , [
                        $field->name => request()->input($selector) ,
                    ]);

                    $this->traitResource['fields'] = array_merge($this->traitResource['fields'] , [ $field->name => $field ]);

                    $this->traitResource($field->fields , $selector);


                }

            }
        }

        /**
         *
         */
        private function traitResourceSave($fields , $selector = null , $id = null , $model_id = null)
        {

            foreach($fields as $field)
            {

                if(isset($field->data))
                {
                    $this->traitResource($field->data , $selector , $id , $model_id);
                }

//                if(method_exists($field , 'authorizedToSee') && $field->authorizedToSee() === true &&
//                    method_exists($field , 'showOnUpdate') && $field->showOnUpdate == true &&
//                    method_exists($field , 'OnUpdate') && $field->OnUpdate == true){
////                    Arr::add($this->traitResource,[$field->name => ])
//                }

                if($field instanceof Repeater)
                {

                    if(is_null($selector))
                    {
                        $selector .= $field->name;
                        $selector_2 = $field->name;
                    }
                    else
                    {
                        $selector .= '.*.' . $field->name;
                        $selector_2 = '.*.' . $field->name;
                    }

                    if(class_exists($field->model))
                    {
                        for($i = 0; $i <= count(request()->input($selector . '.*')); $i++)
                        {
                            $inputs = request()->input(str_replace_last('*' , $i , $selector_2));
                            if($this->inputCheckHasTable($inputs) == 0)
                            {
                                foreach($inputs as $input)
                                    $model_id = $field->model::create(array_merge([ 'post_id' => $model_id ] , $input));
                            }
                        }
                    }

                    $this->traitResourceSave($field->fields , $selector , $id , $model_id);
                }

            }

        }

        /**
         * @param $input
         *
         * @return int
         */
        private function inputCheckHasTable($input)
        {
            $flag = 0;
            foreach($input as $key => $name)
            {
                if(is_array($name))
                {
                    foreach($name as $key_2 => $name_2)
                    {

                        if(isset($this->traitResource['fields'][$key_2]) && $this->traitResource['fields'][$key_2]->model != null)
                        {
                            $flag = 1;
                        }
                    }
                }
                if(isset($this->traitResource['fields'][$key]) && $this->traitResource['fields'][$key]->model != null)
                {
                    $flag = 1;
                }
            }

            return $flag;
        }


    }
