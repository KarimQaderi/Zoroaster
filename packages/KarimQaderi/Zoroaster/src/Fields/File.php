<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class File extends Field
    {


        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'file';


        /**
         * The callback used to retrieve the thumbnail URL.
         *
         * @var callable
         */
        public $thumbnailUrlCallback;

        /**
         * The callback used to retrieve the preview URL.
         *
         * @var callable
         */
        public $previewUrlCallback;

        /**
         * The callback used to generate the download HTTP response.
         *
         * @var callable
         */
        public $downloadResponseCallback;

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
         * The callback that should be used to determine the file's storage name.
         *
         * @var callable|null
         */
        public $storeAsCallback;

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


        public function __construct(string $label , ?string $name = null , ?mixed $resolveCallback = null)
        {
            parent::__construct($label , $name , $resolveCallback);

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
         * Specify the callback that should be used to retrieve the thumbnail URL.
         *
         * @param  callable $thumbnailUrlCallback
         * @return $this
         */
        public function thumbnail(callable $thumbnailUrlCallback)
        {
            $this->thumbnailUrlCallback = $thumbnailUrlCallback;

            return $this;
        }

        /**
         * Specify the callback that should be used to retrieve the preview URL.
         *
         * @param  callable $previewUrlCallback
         * @return $this
         */
        public function preview(callable $previewUrlCallback)
        {
            $this->previewUrlCallback = $previewUrlCallback;

            return $this;
        }

        /**
         * Specify the callback that should be used to create a download HTTP response.
         *
         * @param  callable $downloadResponseCallback
         * @return $this
         */
        public function download(callable $downloadResponseCallback)
        {
            $this->downloadResponseCallback = $downloadResponseCallback;

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
         * Get additional meta information to merge with the element payload.
         *
         * @return array
         */
        public function meta()
        {
            return array_merge([
                'thumbnailUrl' => $this->resolveThumbnailUrl() ,
                'previewUrl' => call_user_func($this->previewUrlCallback) ,
                'downloadable' => isset($this->downloadResponseCallback) && !empty($this->value) ,
                'deletable' => isset($this->deleteCallback) && $this->deletable ,
            ] , $this->meta);
        }


    }