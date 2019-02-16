<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use Illuminate\Support\Facades\Hash;
    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    class Password extends Field
    {
        use Resource;

        public $nameViewForm = 'password';

        public function __construct(string $label , ?string $name = null)
        {
            parent::__construct($label , $name);

            $this->onlyOnForms();
        }

        public function ResourceUpdate(RequestField $requestField)
        {
           return $this->TraitResource($requestField);
        }

        public function ResourceStore(RequestField $requestField)
        {
            return $this->TraitResource($requestField);
        }

        public function beforeResourceStore(RequestField $requestField)
        {
            return $this->TraitResource($requestField);
        }

        private function TraitResource(RequestField $requestField)
        {

            $value = $requestField->request->{$requestField->field->name};

            if(empty($value))
                return [
                    'error' => $this->getValidatorField($requestField) ,
                    'data' => [] ,
                ];
            else
                return [
                    'error' => $this->getValidatorField($requestField) ,
                    'data' => [$requestField->field->name => Hash::make($value)] ,
                ];

        }


    }