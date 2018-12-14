<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use App\models\Post;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\ResourceFilters\DefaultFilters;

    class ResourceIndexController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            $request->authorizeTo($request->Resource()->authorizeToIndex($request->Model()));

            $resources = $request->Model();

            $resources = $this->toQuery($resources , $request);

            return view('Zoroaster::resources.index')->with([
                'request' => $request ,
                'resourceClass' => $request->Resource() ,
                'model' => $request->Model() ,
                'resources' => $resources ,
                'fields' => $request->ResourceFields(function($field){
                    if($field !== null && $field->showOnIndex == true)
                        return true;
                    else
                        return false;
                }) ,
            ]);

        }


        private function toQuery($resources , ResourceRequest $request)
        {

            if(request()->has('search'))
                $resources = $resources->where(function($q) use ($request){
                    foreach($request->Resource()->search as $field){
                        $q->orWhere($field , 'like' , '%' . request()->search . '%');
                    }
                });



            // Sort Table
            if(request()->has('sortable_direction') && request()->has('sortable_field'))
                $resources = $resources->orderBy(request()->sortable_field,request()->sortable_direction);



            // indexQuery
            if($request->Resource()->indexQuery($resources) !== null)
                $resources = $request->Resource()->indexQuery($resources);


            // filters
            $filters = (new DefaultFilters())->hendle();
            if($request->Resource()->filters() != null)
                $filters = array_merge($request->Resource()->filters() , $filters);

            foreach($filters as $filter){
                if($filter->canSee($request))
                    $resources = $filter->apply($resources , $request);
            }


            return $resources;

        }

    }