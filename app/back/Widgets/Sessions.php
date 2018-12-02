<?php

    namespace App\back\Widgets;


    class Sessions
    {

        /**
         * The configuration array.
         *
         * @var array
         */
        protected $config = [];
        private $getFileCacheCount = 0;
        private $getFileCacheFolder = 0;

        /**
         * Treat this method as a controller action.
         * Return view() or other content to display.
         */
        public function run()
        {

            return view('back.widgets.sessions')->with([
                'size_cache' => (object)[
                    'size' => self::getFileCacheSize() ,
                    'count' => $this->getFileCacheCount ,
                    'folder' => $this->getFileCacheFolder ,
                ] ,
            ]);
        }

        /**
         * Returns the size of a folder in bytes.
         *
         * @param string $folder
         * @return int
         */
        public function getFolderSizeInBytes($folder)
        {
            $size = 0;
            $this->getFileCacheCount++;

            foreach(glob(rtrim($folder , '/') . '/*' , GLOB_NOSORT) as $each){
                $size += is_file($each) ? filesize($each) : self::getFolderSizeInBytes($each);
                $this->getFileCacheFolder++;

            }
            return $size;
        }

        /**
         * Converts a file size from bytes to a human readable string.
         *
         * @param int $size
         * @return string
         */
        public function sizeInBytesToReadable($size)
        {
            if($size < 1024){
                $size = $size . " Bytes";
            } else if($size < 1048576 && $size > 1023){
                $size = round($size / 1024 , 1) . " KB";
            } else if($size < 1073741824 && $size > 1048575){
                $size = round($size / 1048576 , 1) . " MB";
            } else{
                $size = round($size / 1073741824 , 1) . " GB";
            }
            return $size;
        }

        /**
         * Returns the current size of the local file cache if it is enabled.
         *
         * @return string
         */
        public function getFileCacheSize()
        {
            $path = config('session.files');
            if(!file_exists($path)) return '';
            $sizeInBytes = self::getFolderSizeInBytes($path);
            return self::sizeInBytesToReadable($sizeInBytes);
        }


    }