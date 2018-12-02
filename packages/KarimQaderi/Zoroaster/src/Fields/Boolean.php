<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    class Boolean extends Field
    {

        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'boolean';
        public $textAlign = 'center';

        public $customResourceController = true;


//        public function ResourceUpdate($request , $resource , $field)
//        {
//
//            $value = $request->{$field->name};
//
//            $resource->update([
//                $field->name => ($value === 'on' || $value === 1) ? 1 : 0
//            ]);
//        }
//
//        public function ResourceStore($request , $resource , $field)
//        {
//            $value = $request->{$field->name};
//
//            $resource->update([
//                $field->name => ($value === 'on' || $value === 1) ? 1 : 0
//            ]);
//        }

        public function ResourceUpdate(RequestField $requestField)
        {

            $value = $requestField->request->{$requestField->field->name};

            $requestField->resource->update([
                $requestField->field->name => ($value === 'on' || $value === 1) ? 1 : 0
            ]);
        }

        public function ResourceStore(RequestField $requestField)
        {
            $value = $requestField->request->{$requestField->field->name};

            $requestField->resource->update([
                $requestField->field->name => ($value === 'on' || $value === 1) ? 1 : 0
            ]);
        }


    }