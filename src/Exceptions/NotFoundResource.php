<?php

    namespace KarimQaderi\Zoroaster\Exceptions;

    use Illuminate\Support\Arr;
    use RuntimeException;

    class NotFoundResource extends RuntimeException
    {

        public function setResource($resource)
        {

            $this->message = "Not Found Resource [{$resource}]";

            return $this;
        }

    }