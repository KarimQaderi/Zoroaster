<?php


    namespace KarimQaderi\Zoroaster;


    class Builder
    {

        public function builder($builders , $where , $viewForm = null)
        {
            $Fields = is_null($viewForm) ? [] : null;

            foreach($builders as $builder){
                $select = null;
                switch(true){
                    case isset($field->data):
                        if(is_null($viewForm))
                            $select = array_merge($Fields , $this->builder($where , $field->data));
                        else
                            $select = $builder->$viewForm($this->builder($where , $view , $resources , $field->data) , $field , $this->Resource());
                        break;

                    default:
                        $select [] = $builder;
                        break;
                }

                if(is_null($viewForm))
                    $Fields [] = $select;


            }

            return $Fields;
        }


    }