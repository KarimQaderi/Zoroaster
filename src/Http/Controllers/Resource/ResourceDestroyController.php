<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceDestroyController extends Controller
    {
        public function handle(ResourceRequest $ResourceRequest)
        {
            foreach(request()->resourceId as $id){

                /**
                 * نظر مورد رکورد کردن پیدا
                 *
                 * @var Model $find
                 */
                $find = $ResourceRequest->find($id);


                /**
                 * دسترسی سطح بررسی
                 */
                if($ResourceRequest->Resource()->authorizedToForceDelete($find)){

                    /**
                     * ها فیلد به حذف درخواست ارسال
                     * بشن حذف هم فیلد اون های عکس باید شه می حذف Resource رکورد وقتی بگیرید نظر در رو عکس فیلد یه مثال برای
                     */
                    $ResourceRequest->CustomResourceController($ResourceRequest , $find ,'ResourceDestroy' , function($field){
                        return true;
                    });

                    if($ResourceRequest->isForceDeleting())
                        $find->forceDelete();
                    else
                        $ResourceRequest->Resource()->newModel()->destroy($id);
                }

            }


            if(request()->has('redirect'))
                redirect(request()->redirect)->with(['success' => 'منبع مورد نظر حذف شد'])->send();

            return response(['status' => 'ok']);
        }


    }