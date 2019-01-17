<?php

    namespace KarimQaderi\Zoroaster\Fields\Traits;


    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Validator as MainValidator;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    trait Validator
    {


        /**
         * @param RequestField $requestField
         * @return |null
         * @throws \Exception
         */
        private function getValidatorField($requestField)
        {
            $fieldName = $requestField->field->name;
            $field = \Zoroaster::ResourceFieldFind( $fieldName, $requestField->fieldAll);
            $validator = MainValidator::make(
                $requestField->MergeResourceFieldsAndRequest->request ,
                [
                    $fieldName => $field->rules
                ]
                , [] ,
                $requestField->MergeResourceFieldsAndRequest->customAttributes);


            if($validator->fails())
                return $validator->messages();


            return null;

        }

        private function validator(RequestField $requestField)
        {
            $validator = MainValidator::make($requestField->MergeResourceFieldsAndRequest->request , $requestField->MergeResourceFieldsAndRequest->validator , [] , $requestField->MergeResourceFieldsAndRequest->customAttributes);
            if($validator->fails()){
                $resp = redirect()->back()->withErrors($validator->messages())->withInput();
                Session::save();
                $resp->send();
                exit();
            }
        }

        private function SendErrors($validator)
        {
            $resp = redirect()->back()->withErrors($validator)->withInput();
            Session::save();
            $resp->send();
            exit();

        }
    }