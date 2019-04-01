<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceRestoreController extends Controller
    {
        public function handle(ResourceRequest $request)
        {
            $cols = null;
            $col = null;
            foreach(request()->resourceId as $id){

                /**
                 * نظر مورد رکورد کردن پیدا
                 */
                $find = $request->find();


                /**
                 * رکورد بازیابی و دستررسی سطح بررسی
                 */
                if(!is_null($find) && $request->Resource()->authorizedToRestore($find))
                    $find->restore();

                $where = function($field){
                    if($field !== null && $field->showOnIndex == true)
                        return true;
                    else
                        return false;
                };

                /**
                 * ها Action دوباره گرفتن
                 */
                $col = \Zoroaster::ResourceActions(
                    $request->Resource() ,
                    $find ,
                    $request->Resource()->newModel() , 'Index' , $request->ResourceFields($where)
                );

                $cols [] = [
                    'id' => $id ,
                    'col' => $col ,
                    'status' => 'ok' ,
                ];


            }


            if(request()->has('redirect'))
                redirect(request()->redirect)->with(['success' => 'منبع مورد نظر حذف شد'])->send();

            return response($cols);
        }

    }