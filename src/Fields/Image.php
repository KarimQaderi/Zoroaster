<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Intervention\Image\ImageManagerStatic as ImageResize;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    class Image extends File
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;


        public $nameViewForm = 'image';
        public $resize = [];
        public $thumbnail = null;


        public function resize($name , $width , $hight)
        {
            $this->resize [] = [
                'name' => $name ,
                'width' => $width ,
                'hight' => $hight ,
            ];

            return $this;
        }


        public function ResourceUploadDelete(Request $request , $resourceField)
        {

            Storage::disk($resourceField->disk)->delete($request->url);

            if(is_array(html_entity_decode($request->resize)))
                foreach(html_entity_decode($request->resize) as $key => $value){
                    Storage::disk($resourceField->disk)->delete($value->url);
                }

            return 'ok';
        }


        public function ResourceUpload(Request $request , $resourceField)
        {


            $originalName = call_user_func($resourceField->originalName , $request->file('file'));


            $url = $request->file('file')->storeAs(
                $resourceField->getPathUpload() , $originalName , ['disk' => $resourceField->disk]
            );


            $RealPath = Storage::disk($resourceField->disk)->url($url);


            $resizeItem = [];
            if(isset($resourceField->resize) && $resourceField->resize !== null){

                $Image = ImageResize::make($request->file('file'));

                foreach($resourceField->resize as $key => $value){
                    $value = (object)$value;
                    $thumbName = $value->width . 'x' . $value->hight . '-' . $originalName;
                    $Image->resize($value->width , $value->hight);
                    Storage::disk($resourceField->disk)->put(\Zoroaster::urlFix($resourceField->getPathUpload() . '/' . $thumbName) , (string)$Image->encode());

                    $resizeItem[] = [
                        'name' => $value->name ,
                        'resize' => $value->width . '*' . $value->hight ,
                        'url' => \Zoroaster::urlFix($resourceField->getPathUpload() . '/' . $thumbName) ,
                    ];
                }
            }

            return response()->json([
                'url' => $url ,
                'RealPath' => $RealPath ,
                'resize' => htmlspecialchars(json_encode($resizeItem)) ,
                'number' => time() . '' . random_int(100 , 1000)

            ]);

        }


        public function beforeResourceStore(RequestField $requestField)
        {
            return $this->traitResource($requestField);

        }

        public function ResourceStore(RequestField $requestField)
        {
            return $this->traitResource($requestField);

        }

        public function ResourceUpdate(RequestField $requestField)
        {
            return $this->traitResource($requestField);
        }

        public function traitResource(RequestField $requestField)
        {
            $values = $requestField->request->{$requestField->field->name};

            $setValues = null;
            if($values != null)
                foreach($values as $value){
                    if(count($values) == 1){
                        if((($value['resize'])) == '[]')
                            $setValues = $value['url'];
                        else
                            $setValues = [
                                'url' => $value['url'] ,
                                'resize' => ($value['resize']) ,
                            ];

                    } else{
                        if(count(json_decode($value['resize'])) == 0)
                            $setValues [] = ['url' => $value['url']];
                        else
                            $setValues [] = [
                                'url' => $value['url'] ,
                                'resize' => ($value['resize']) ,
                            ];
                    }

                }

            return [
                'error' => $this->getValidatorField($requestField) ,
                'data' => [$requestField->field->name => $setValues] ,
            ];

        }


    }