<?php

    namespace KarimQaderi\Zoroaster\Fields\Traits;


    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Validator;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    trait Resource
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        public function beforeResourceStore(RequestField $requestField)
        {

            $this->validator($requestField);

            $value = $requestField->request->{$requestField->field->name};

            return [$requestField->field->name => $value];
        }

        public function ResourceStore(RequestField $requestField)
        {
            $this->validator($requestField);

            $value = $requestField->request->{$requestField->field->name};

            return [$requestField->field->name => $value];
        }

        public function ResourceUpdate(RequestField $requestField)
        {

            $this->validator($requestField);

            $value = $requestField->request->{$requestField->field->name};

            return [$requestField->field->name => $value];

        }


    }