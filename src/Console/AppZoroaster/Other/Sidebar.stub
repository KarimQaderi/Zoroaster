<?php

    namespace App\Zoroaster\Other;


    use KarimQaderi\Zoroaster\Sidebar\FieldMenu\Divider;
    use KarimQaderi\Zoroaster\Sidebar\FieldMenu\Menu;
    use KarimQaderi\Zoroaster\Sidebar\FieldMenu\MenuItem;
    use KarimQaderi\Zoroaster\Sidebar\SidebarHeader;

    class Sidebar
    {
        static function handle()
        {
            return [

                SidebarHeader::make() ,

                Menu::make([
                    MenuItem::make()->route('Zoroaster.home' , 'داشبورد')->icon('home') ,
                    Divider::make() ,
                    MenuItem::make()->resource('Post')->icon('list') ,
                    MenuItem::make()->resource('User')->icon('users') ,
                    MenuItem::make()->resource('Migration')->icon('settings') ,
                    MenuItem::make()->route('Zoroaster.settings.icons' , 'ایکون ها')->icon('hashtag') ,
                ]) ,

            ];
        }
    }