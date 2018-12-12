<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Zoroaster;

    class PivotCheckBox extends Field
    {

        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'pivot_check_box';


        public $model_pivot = null;
        public $model_pivot_foreign_key = null;
        public $model_pivot_other_key = null;
        public $model_pivot_add_with = [];

        public $model_show = null;
        public $model_show_foreign_key = null;
        public $model_show_title = null;


        public function pivot($model , $foreign_key , $other_key)
        {
            $this->model_pivot_foreign_key = $foreign_key;
            $this->model_pivot_other_key = $other_key;
            $this->model_pivot = $model;

            return $this;
        }

        public function show($model , $title = null , $foreign_key = 'id')
        {
            $this->model_show_foreign_key = $foreign_key;
            $this->model_show = $model;
            $this->model_show_title = $title;

            return $this;
        }

        public function addWith(array $With)
        {
            $this->model_pivot_add_with = $With;

            return $this;
        }


        public function viewForm($data , $field , $newResource = null)
        {
            return view('Zoroaster::fields.Form.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                    'show' => Zoroaster::newModel($field->model_show)->get() ,
                    'pivot' => Zoroaster::newModel($field->model_pivot)
                        ->where($field->model_pivot_foreign_key , $data->{$data->getKeyName()})->get()
                        ->pluck($field->model_pivot_other_key)->toArray() ,
                ]);
        }

        public function viewDetail($data , $field , $newResource = null)
        {
            $pivot = [];

            foreach(Zoroaster::newModel($field->model_pivot)
                        ->where($field->model_pivot_foreign_key , $data->{$data->getKeyName()})->get()
                        ->pluck($field->model_pivot_other_key)->toArray() as $p){
                $pivot [] = [
                    'id' => $p ,
                    'name' => Zoroaster::newModel($field->model_show)->where($field->model_show_foreign_key , $p)->first()->{$field->model_show_title} ,
                ];
            }

            return view('Zoroaster::fields.Detail.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                    'pivot' => $pivot ,
                ]);
        }

        public function viewIndex($data , $field , $newResource = null)
        {
            $pivot = [];

            foreach(Zoroaster::newModel($field->model_pivot)
                        ->where($field->model_pivot_foreign_key , $data->{$data->getKeyName()})->get()
                        ->pluck($field->model_pivot_other_key)->toArray() as $p){
                $pivot [] = [
                    'id' => $p ,
                    'name' => Zoroaster::newModel($field->model_show)->where($field->model_show_foreign_key , $p)->first()->{$field->model_show_title} ,
                ];
            }

            return view('Zoroaster::fields.Index.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                    'pivot' => $pivot ,
                ]);
        }


        public function ResourceDestroy(RequestField $requestField)
        {

            Zoroaster::newModel($requestField->field->model_pivot)
                ->where([
                    $requestField->field->model_pivot_foreign_key => $requestField->resource->{$requestField->resource->getKeyName()}
                ])->delete();

            return [
                'error' => [] ,
            ];
        }

        public function beforeResourceStore(RequestField $requestField)
        {
            return [
                'error' => $this->getValidatorField($requestField) ,
                'data' => [] ,
            ];
        }

        public function ResourceStore(RequestField $requestField)
        {
            return $this->TraitResource($requestField);
        }

        public function ResourceUpdate(RequestField $requestField)
        {
            return $this->TraitResource($requestField);
        }

        private function TraitResource(RequestField $requestField)
        {

            $values = $requestField->request->{$requestField->field->name};

            $time = [];
            if(Zoroaster::newModel($requestField->field->model_pivot)->timestamps == true)
                $time = [
                    "created_at" => now() ,
                    "updated_at" => now() ,
                ];

            $data = [];
            foreach($values as $value){
                $data [] = array_merge([
                    $requestField->field->model_pivot_foreign_key => $requestField->resource->{$requestField->resource->getKeyName()} ,
                    $requestField->field->model_pivot_other_key => $value ,
                ] , $time , $requestField->field->model_pivot_add_with);
            }


            Zoroaster::newModel($requestField->field->model_pivot)
                ->where([$requestField->field->model_pivot_foreign_key => $requestField->resource->{$requestField->resource->getKeyName()}])
                ->delete();


            (Zoroaster::newModel($requestField->field->model_pivot)->insert($data));
            return [
                'error' => $this->getValidatorField($requestField) ,
                'data' => [] ,
            ];
        }


    }


