<?php


    namespace KarimQaderi\Zoroaster\Abstracts;


    Abstract class SidebarAbstract
    {

        /**
         * سایت اصلی منوی بالای
         *
         * @return array
         */
        Abstract public static function Top();

        /**
         * سایت اصلی منوی قسمت
         *
         * @return array
         */
        Abstract public static function Menu();

        /**
         * سایت اصلی منوی پایین
         *
         * @return array
         */
        Abstract public static function Bottom();
    }