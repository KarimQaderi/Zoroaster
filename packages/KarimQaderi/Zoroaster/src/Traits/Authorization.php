<?php

    namespace KarimQaderi\Zoroaster\Traits;


    trait Authorization
    {


        /**
         * @return bool
         */
        public function authorizeToIndex($model)
        {
            return true;
        }


        /**
         * @return bool
         */
        public function authorizeToShow($data)
        {
            return true;
        }


        /**
         * @return bool
         */
        public function authorizeToCreate($model)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizeToUpdate($data)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizeToDelete($data)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizedToAdd($data)
        {
            return true;
        }

    }