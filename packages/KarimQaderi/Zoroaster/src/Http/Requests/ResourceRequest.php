<?php

    namespace KarimQaderi\Zoroaster\Http\Requests;


    use KarimQaderi\Zoroaster\Builder;
    use KarimQaderi\Zoroaster\Traits\BuilderFieldsForm;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest as TraitsResourceRequest;

    class ResourceRequest
    {
        use TraitsResourceRequest , Builder;

        function authorizeTo($authorize)
        {
            if(!$authorize)
                abort(401);
        }

    }