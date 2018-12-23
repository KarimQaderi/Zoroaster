<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class AjaxFieldController extends Controller
    {
        public function handle(Request $request)
        {
            if(method_exists(\Zoroaster::getFieldResource($request->resource , $request->field) , $request->controller))
                return \Zoroaster::getFieldResource($request->resource , $request->field)->{$request->controller}($request , \Zoroaster::getFieldResource($request->resource , $request->field));
            else
                return response('method پیدا نشد');
        }

    }