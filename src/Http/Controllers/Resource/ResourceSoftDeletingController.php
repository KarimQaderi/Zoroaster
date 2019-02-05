<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceSoftDeletingController extends Controller
    {
        public function handle(ResourceRequest $request)
        {
            $cols = null;
            $col = null;
            foreach(request()->resourceId as $id){

                /**
                 * نظر مورد رکورد کردن پیدا
                 */
                $find = $request->find($id);

                /**
                 * رکورد حذف و دستررسی سطح بررسی
                 */
                if(!is_null($find) && $request->Resource()->authorizedToDelete($find))
                    $find->delete();

                /**
                 * ها Action دوباره گرفتن
                 */
                $col = \Zoroaster::ResourceActions($request->Resource() , $find ,
                    $find, 'Index' , $request->ResourceFields(function($field){
                        if($field !== null && $field->showOnIndex == true)
                            return true;
                        else
                            return false;
                    })
                );

                $cols [] = [
                    'id' => $id ,
                    'col' => $col ,
                    'status' => 'ok' ,
                ];


            }


            if(request()->has('redirect'))
                redirect(request()->redirect)->with(['success' => 'منبع مورد نظر حذف شد' ])->send();

            return response($cols);
        }

    }