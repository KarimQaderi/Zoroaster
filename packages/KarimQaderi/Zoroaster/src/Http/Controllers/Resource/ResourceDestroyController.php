<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceDestroyController extends Controller
    {
        public function handle(ResourceRequest $request)
        {
            $request->Model()->destroy(request()->resourceId);
            return response([
                'status' => 'ok'
            ]);
        }

}