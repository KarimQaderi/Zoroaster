<?php

    namespace KarimQaderi\Zoroaster\Exceptions;

    use Illuminate\Support\Arr;
    use RuntimeException;

    class NotFoundModel extends RuntimeException
    {

        public function setField($field)
        {

            $this->message = "Not Found Model [{$field}]";

            return $this;
        }

    }