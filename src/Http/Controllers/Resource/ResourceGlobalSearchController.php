<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Zoroaster;

    class ResourceGlobalSearchController extends Controller
    {
        public function handle(Request $request)
        {
            $render = null;
            foreach(Zoroaster::$resources as $Resource){

                /** @var ZoroasterResource $newResource */
                $newResource = new $Resource;
                $model = $newResource->newModel();

                if($newResource->globallySearchable && $newResource->authorizedToIndex($model)){

                    $resources = $model->where(function($q) use ($request , $newResource){
                        foreach($newResource->search as $field)
                            $q->orWhere($field , 'like' , '%' . $request->search . '%');
                    })->limit(5)->get();

                    $render .= view('Zoroaster::resources.GlobalSearch')
                        ->with([
                            'newResource' => $newResource ,
                            'model' => $model ,
                            'data' => $resources ,
                        ]);
                }
            }

            return $render;

        }
    }