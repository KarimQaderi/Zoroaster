<?php

    namespace KarimQaderi\Zoroaster\Fields\Traits;


    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    trait View
    {
        /**
         * @param Field $field
         * @param $data
         * @param null $resourceRequest
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewForm($field , $data , $resourceRequest = null)
        {
            try{

                return view('Zoroaster::fields.Form.' . $field->nameViewForm)->with(
                    [
                        'field' => $field ,
                        'data' => $data ,
                        'value' => isset($data->{$field->name}) ? $data->{$field->name} : null ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch(\Exception $exception){
                throw new \Exception($exception);
            }

        }

        /**
         * @param Field $field
         * @param $data
         * @param null $resourceRequest
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewDetail($field , $data , $resourceRequest = null)
        {

            try{
                return view('Zoroaster::fields.Detail.' . $field->nameViewForm)->with(
                    [
                        'field' => $field ,
                        'data' => $data ,
                        'value' => $this->displayCallback($data , $resourceRequest , $field) ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch(\Exception $exception){
                throw new \Exception($exception);
            }
        }

        /**
         * @param $field
         * @param $data
         * @param ResourceRequest $resourceRequest
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewIndex($field , $data , $resourceRequest = null)
        {

            try{

                return view('Zoroaster::fields.Index.' . $field->nameViewForm)->with(
                    [
                        'field' => $field ,
                        'data' => $data ,
                        'value' => $this->displayCallback($data , $resourceRequest , $field) ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch(\Exception $exception){
                throw new \Exception($exception);
            }
        }


        public function displayCallback($data , $resourceRequest , $field)
        {
            if(is_callable($field->displayCallback))
                return call_user_func($field->displayCallback , $data , $resourceRequest , $field);

            return data_get($data , $field->name);
        }
    }