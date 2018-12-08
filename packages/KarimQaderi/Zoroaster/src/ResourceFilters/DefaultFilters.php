<?php


    namespace KarimQaderi\Zoroaster\ResourceFilters;


    class DefaultFilters
    {
        public function hendle()
        {
            return [

                new Trashed() ,
                new PerPage() ,

            ];

        }
    }