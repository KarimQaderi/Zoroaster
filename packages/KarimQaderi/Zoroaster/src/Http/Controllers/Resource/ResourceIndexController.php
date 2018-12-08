<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceIndexController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            $request->authorizeTo($request->Resource()->authorizeToIndex($request->Model()));

            $resources = $request->Model();
            $resources = $this->toQuery($resources , $request);

            if($request->Resource()->AddingAdditionalConstraintsForViewIndex($resources) !== null)
                $resources = $request->Resource()->AddingAdditionalConstraintsForViewIndex($resources);

            $resources = $resources->paginate(((int)$request->Request()->perPage ?? 25));

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
            if($request->Resource()->filters() != null)
                foreach($request->Resource()->filters() as $filter){
                    if($filter->canSee($request))
                        $resources = $filter->handle($resources , $request);
                }


            if(request()->has('search'))
                $resources = $resources->where(function($q) use ($request){
                    foreach($request->Resource()->search as $field){
                        $q->orWhere($field , 'like' , '%' . request()->search . '%');
                    }
                });

            return $resources;

        }

    }