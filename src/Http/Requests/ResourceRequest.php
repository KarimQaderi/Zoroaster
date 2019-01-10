<?php

    namespace KarimQaderi\Zoroaster\Http\Requests;


    use KarimQaderi\Zoroaster\Traits\Builder;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest as TraitsResourceRequest;
    use phpDocumentor\Reflection\Types\This;

    class ResourceRequest
    {
        use TraitsResourceRequest , Builder;

        function authorizeTo($authorize)
        {
            if(!$authorize)
                abort(401);
        }


        function getModelAndWhereTrashed()
        {
            if(method_exists($this->newModel() , 'isForceDeleting'))
                return $this->newModel()->withTrashed();
            else
                return $this->newModel();
        }

        function isForceDeleting()
        {
            return method_exists($this->newModel() , 'isForceDeleting');
        }

    }