<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers;

    use App\Http\Controllers\Controller;

    class UpdateFieldController extends Controller
    {
        public function handle(ResourceIndexRequest $request)
        {

            $resources = $request->Model()->paginate(($request->Request()->perPage ?? 25));

            return view('Zoroaster::resources.index')->with([
                'request' => $request,
                'resourceClass' => $request->Resource(),
                'model' => $request->Model(),
                'resources' => $resources,
                'fields' => $request->Fields(),
            ]);
        }



    protected function Query($request)
    {

    }

}