<?php


    namespace KarimQaderi\Zoroaster\Http\Requests;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;

    class RequestField
    {
        public $request = null;

        /** @var Model & Builder $resource */
        public $resource = null;

        /** @var \KarimQaderi\Zoroaster\Fields\Extend\Field $field */
        public $field = null;
        public $fieldAll = null;
        public $MergeResourceFieldsAndRequest = null;
    }