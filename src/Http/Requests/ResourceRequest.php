<?php

    namespace KarimQaderi\Zoroaster\Http\Requests;


    use KarimQaderi\Zoroaster\Traits\Builder;
    use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
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