<?php

    namespace KarimQaderi\Zoroaster\Exceptions;

    use Illuminate\Support\Arr;
    use RuntimeException;

    class NotFoundField extends RuntimeException
    {

        public function setField($field)
        {

            $this->message = "Not Found Field [{$field}]";

            return $this;
        }

    }