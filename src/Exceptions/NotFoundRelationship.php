<?php

    namespace KarimQaderi\Zoroaster\Exceptions;

    use Illuminate\Support\Arr;
    use RuntimeException;

    class NotFoundRelationship extends RuntimeException
    {

        public function setRelationship($Relationship)
        {

            $this->message = "Not Found Relationship [{$Relationship}]";

            return $this;
        }

    }