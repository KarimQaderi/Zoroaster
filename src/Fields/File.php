<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    class File extends Field
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        public $nameViewForm = 'file';


        /**
         * max File upload
         *
         * @var int
         */
        public $count = 1;



        /**
         * The name of the disk the file uses by default.
         *
         * @var string
         */
        public $disk = 'public';

        /**
         * The file storage path.
         *
         * @var string
         */
        public $storagePath = '/';


        /**
         * The column where the file's original name should be stored.
         *
         * @var string
         */
        public $originalName = null;


        /**
         * The text alignment for the field's text in tables.
         *
         * @var string
         */
        public $textAlign = 'center';


        public function __construct(string $label , ?string $name = null)
        {
            parent::__construct($label , $name);

            $this->originalName = function($file){
                return $this->originalName = $file->getClientOriginalName();
            };

        }


        /**
         * Set the name of the disk the file is stored on by default.
         *
         * @param  string $disk
         * @return $this
         */
        public function disk($disk)
        {
            $this->disk = $disk;

            return $this;
        }


        /**
         * Set the file's storage path.
         *
         * @param  string $path
         * @return string
         */
        public function path($path)
        {
            $this->storagePath = $path;

            return $this;
        }


        /**
         * Specify the column where the file's original name should be stored.
         *
         * @param  string $column
         * @return $this
         */
        public function storeOriginalName($file)
        {
            $this->originalName = $file;

            return $this;
        }


        public function getPathUpload()
        {
            if(is_string($this->storagePath))
                return $this->storagePath;
            else
                return call_user_func($this->storagePath);
        }

        /**
         * @param $count int  upload ( default = 1 )
         * @return $this
         */
        public function count($count = 1)
        {
            if($count <= 0) $count = 1;
            $this->count = $count;
            return $this;
        }

        /**
         * Get additional meta information to merge with the element payload.
         *
         * @return array
         */
        public function meta()
        {
            return array_merge([] , $this->meta);
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


            return response()->json([
                'url' => $url ,
                'RealPath' => $RealPath ,
                'number' => time() . '' . random_int(100 , 1000),
                'baseName' => $originalName

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
                    if(count($values) == 1)
                        $setValues = $value['url'];
                    else
                        $setValues [] = $value['url'];
                }

            return [
                'error' => $this->getValidatorField($requestField) ,
                'data' => [$requestField->field->name => $setValues] ,
            ];

        }

    }