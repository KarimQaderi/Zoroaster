<?php


    namespace KarimQaderi\Zoroaster\Abstracts;


    abstract class NavbarAbstract
    {
        /**
         * Navbar چپ سمت
         *
         * @return array
         */
        abstract public static function Left();

        /**
         * Navbar وسط سمت
         *
         * @return array
         */
        abstract public static function Center();

        /**
         * Navbar راست سمت
         *
         * @return array
         */
        abstract public static function Right();

    }