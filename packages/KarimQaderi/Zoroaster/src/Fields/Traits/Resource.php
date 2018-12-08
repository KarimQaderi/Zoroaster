<?php

    namespace KarimQaderi\Zoroaster\Fields\Traits;


    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    trait Resource
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        public function beforeResourceStore(RequestField $requestField)
        {

            $value = $requestField->request->{$requestField->field->name};

            return [
                'error' => $this->getValidatorField($requestField),
                'data' => [$requestField->field->name => $value] ,
            ];
        }

        public function ResourceStore(RequestField $requestField)
        {

            $value = $requestField->request->{$requestField->field->name};

            return [
                'error' => $this->getValidatorField($requestField),
                'data' => [$requestField->field->name => $value] ,
            ];
        }

        public function ResourceUpdate(RequestField $requestField)
        {

            $value = $requestField->request->{$requestField->field->name};

            return [
                'error' => $this->getValidatorField($requestField),
                'data' => [$requestField->field->name => $value] ,
            ];

        }


    }