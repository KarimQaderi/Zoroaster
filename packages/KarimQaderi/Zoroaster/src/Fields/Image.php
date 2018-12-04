<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    class Image extends File
    {

        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'image';
        public $multiImage = 1;
        public $urlUpload = '/';
        public $resize = [];
        public $customResourceController = true;


        /**
         * @param $count int  image upload ( default = 1 )
         * @return $this
         */
        public function multiImage($count = 1)
        {
            if($count <= 0) $count = 1;
            $this->multiImage = $count;
            return $this;
        }

        public function urlUpload($urlUpload = '/')
        {
            $this->urlUpload = str_finish($urlUpload , '/');
            return $this;
        }



//        public $resize = [
//            'small'=>[
//                'w'=>200,
//                'h'=>300,
//            ]
//        ];

        public function resize($name , $width , $hight)
        {
            $this->resize = array_merge($this->resize , [
                'name' => $name ,
                'width' => $width ,
                'hight' => $hight ,
            ]);

            return $this;
        }


        public function ResourceStore()
        {

        }

        public function ResourceUpdate(RequestField $requestField)
        {
            //
        }


    }