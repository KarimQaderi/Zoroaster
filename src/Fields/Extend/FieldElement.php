<?php

    namespace KarimQaderi\Zoroaster\Fields\Extend;



    abstract class FieldElement extends Element
    {


        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'field';

        /**
         * شدن آپدیت قابلیت
         *
         * @var bool
         */
        public $OnUpdate = true;

        /**
         * شدن اضافه قابلیت
         *
         * @var bool
         */
        public $OnCreation = true;


        /**
         * Index صفحه در مشاهده قابل
         *
         * @var bool
         */
        public $showOnIndex = true;

        /**
         * Detail صفحه در مشاهده قابل
         *
         * @var bool
         */
        public $showOnDetail = true;

        /**
         * Creation صفحه در مشاهده قابل
         *
         * @var bool
         */
        public $showOnCreation = true;

        /**
         * Update صفحه در مشاهده قابل
         *
         * @var bool
         */
        public $showOnUpdate = true;

        /**
         * باشد مخفی Index صفحه داخل در عنصر کنید مشخص
         *
         * @return $this
         */
        public function hideFromIndex()
        {
            $this->showOnIndex = false;

            return $this;
        }

        /**
         * باشد مخفی Detail صفحه داخل در عنصر کنید مشخص
         *
         * @return $this
         */
        public function hideFromDetail()
        {
            $this->showOnDetail = false;

            return $this;
        }

        /**
         * باشد مخفی Creating( صفحه داخل در عنصر کنید مشخص
         *
         * @return $this
         */
        public function hideWhenCreating()
        {
            $this->showOnCreation = false;

            return $this;
        }

        /**
         * باشد مخفی Updating صفحه داخل در عنصر کنید مشخص
         *
         * @return $this
         */
        public function hideWhenUpdating()
        {
            $this->showOnUpdate = false;

            return $this;
        }

        /**
         *  Index صفحه در مشاده قابل فقط
         *
         * @return $this
         */
        public function onlyOnIndex()
        {
            $this->showOnIndex = true;
            $this->showOnDetail = false;
            $this->showOnCreation = false;
            $this->showOnUpdate = false;

            return $this;
        }

        /**
         *  Detail صفحه در مشاده قابل فقط
         *
         * @return $this
         */
        public function onlyOnDetail()
        {
            parent::onlyOnDetail();

            $this->showOnIndex = false;
            $this->showOnDetail = true;
            $this->showOnCreation = false;
            $this->showOnUpdate = false;

            return $this;
        }

        /**
         *  Forms صفحه در مشاده قابل فقط
         *
         * @return $this
         */
        public function onlyOnForms()
        {
            $this->showOnIndex = false;
            $this->showOnDetail = false;
            $this->showOnCreation = true;
            $this->showOnUpdate = true;

            return $this;
        }

        /**
         *  Index - Detail صفحه در مشاده قابل فقط
         *
         * @return $this
         */
        public function exceptOnForms()
        {
            $this->showOnIndex = true;
            $this->showOnDetail = true;
            $this->showOnCreation = false;
            $this->showOnUpdate = false;

            return $this;
        }

    }
