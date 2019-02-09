<?php


    use App\Zoroaster\Other\Dashboard;
    use App\Zoroaster\Other\Navbar;
    use App\Zoroaster\Other\Sidebar;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\ResourceFilters\DefaultFilters;
    use KarimQaderi\Zoroaster\Sidebar\FieldMenu\Menu;
    use KarimQaderi\Zoroaster\Traits\Builder;
    use KarimQaderi\Zoroaster\Zoroaster as SrcZoroaster;


    class Zoroaster
    {
        use Builder;


        /**
         * @return mixed
         */
        public static function getParameterCurrentRoute($parameters)
        {
            if(isset(Route::getCurrentRoute()->parameters()[$parameters]))
                return Route::getCurrentRoute()->parameters()[$parameters];
            else
                return request()->{$parameters};
        }

        /**
         * index صفحه برای فیلترها گرفتن
         * @param \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource $resource
         * @return string|null
         */
        public static function Filters($resource)
        {
            $Filters = null;
            $filters = array_reverse((new DefaultFilters())->hendle());
            if($resource->filters() != null)
                $filters = array_merge($filters , $resource->filters());

            foreach($filters as $filter){
                if($filter->authorizedToSee($resource)){
                    $filter->resourceClassRequest = $resource->uriKey();
                    $Filters .= $filter->render($resource);
                }
            }

            return $Filters;
        }

        /**
         * jsRoute
         *
         * @return array|null
         */
        public static function jsRoute()
        {
            $routes = [];
            $as = SrcZoroaster::$jsRoute;
            foreach(Route::getFacadeRoot()->getRoutes()->getRoutes() as $route){
                if(isset($route->action['as']) && in_array($route->action['as'] , $as)){
                    $as = array_diff($as , [$route->action['as']]);
                    $routes[$route->action['as']] = url($route->uri);
                }
            }

            return $routes;

        }


        /**
         * index صفحه برای Actions گرفتن
         *
         */
        public static function ResourceActions($resource , $data , $model , $view , $field = null)
        {
            $Actions = null;
            foreach($resource->ResourceActions() as $Action){
                if($Action->{'showFrom' . $view} == true && $Action->Authorization($resource , $data))
                    $Actions .= $Action->render($resource , $data , $model , $view , $field);

            }

            return $Actions;
        }


        /**
         * Sidebar گرفتن
         *
         */
        public static function Sidebar()
        {
            return self::RenderDetail(
                array_merge(
                    Sidebar::Top() ,
                    [Menu::make(array_merge(Sidebar::Menu() , KarimQaderi\Zoroaster\Zoroaster::$SidebarMenus))],
                    Sidebar::Bottom()
                ) ,
                null,
                function($field){
                    if(isset($field->canSee) && $field->canSee == false) return false;
                    return true;
                });
        }


        /**
         * scripts گرفتن
         *
         */
        public static function scripts()
        {
            return KarimQaderi\Zoroaster\Zoroaster::$scripts;
        }

        /**
         * styles گرفتن
         *
         */
        public static function styles()
        {
            return KarimQaderi\Zoroaster\Zoroaster::$styles;
        }

        /**
         * @param string $position Left | Right | Center
         *
         * @return null|string
         */
        public static function Navbar($position = 'Left')
        {
            return self::RenderDetail(Navbar::$position());
        }

        /**
         * داشبورد صفحه برای Widgets گرفتن
         *
         */
        public static function Widgets()
        {
            return self::RenderDetail(Dashboard::handle());
        }

        /**
         * Model نام از استفاده با جدید Resource
         *
         * @return \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource
         */
        public static function newResourceByModelName($modelName)
        {
            return KarimQaderi\Zoroaster\Zoroaster::resourceFindByModel(class_basename($modelName));
        }

        /**
         * @param $model
         * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder
         */
        public static function newModel($model)
        {
            return SrcZoroaster::newModel($model);
        }


        /**
         * Resource در فیلد نام براساس فیلد کردن پیدا
         *
         */
        public static function getFieldResource($Resource , $FindNameField)
        {
            return self::ResourceFieldFind($FindNameField , \KarimQaderi\Zoroaster\Zoroaster::resourceFindByUriKey($Resource)->fields());
        }

        /**
         * Resource در فیلد نام براساس فیلد کردن پیدا
         *
         */
        public static function ResourceFieldFind($FindNameField , $fields)
        {
            $find = null;

            foreach($fields as $field){
                switch(true){
                    case isset($field->data):
                        $find = self::ResourceFieldFind($FindNameField , $field->data);
                        break;
                    default:
                        if($field->name == $FindNameField)
                            $find = $field;
                        break;
                }
                if(!is_null($find)) break;
            }

            return $find;
        }

        /**
         * داشبورد صفحه برای Metric گرفتن
         *
         */
        public static function getDashboardMetricFind($find , $data = null)
        {

            $_find = null;

            if(is_null($data)) $data = Dashboard::handle();
            foreach($data as $field){

                switch(true){
                    case isset($field->data):
                        $_find = self::getDashboardMetricFind($find , $field->data);
                        break;
                    default:
                        if(class_basename($field) == $find)
                            $_find = $field;
                        break;
                }

                if(!is_null($_find)) break;

            }

            return $_find;

        }


        static function getMeta($meta , $meta_name)
        {
            if(isset($meta->meta[$meta_name]))
                return $meta->meta[$meta_name];
            else
                return null;
        }

        // $show ==> label Or value Or All
        static function getOptionsSelect($options , $select , $show = 'label')
        {
            $options = Zoroaster::getMeta($options , 'options');
            if($options === null) return null;
            if($select === null) return null;

            foreach($options as $option){
                $option = (object)$option;
                if($option->value == $select){
                    if(in_array($show , ['label' , 'value']))
                        return $option->$show;
                    break;

                }
            }

            return null;
        }


        static function urlFix($url)
        {
            return str_replace('//' , '/' , $url);
        }

        static function url_slug($str , $options = [])
        {
            // Make sure string is in UTF-8 and strip invalid UTF-8 characters
            $str = mb_convert_encoding((string)$str , 'UTF-8' , mb_list_encodings());

            $defaults = [
                'delimiter' => '-' ,
                'limit' => null ,
                'lowercase' => true ,
                'replacements' => [] ,
                'transliterate' => false ,
            ];

            // Merge options
            $options = array_merge($defaults , $options);

            $char_map = [
                // Latin
                'À' => 'A' , 'Á' => 'A' , 'Â' => 'A' , 'Ã' => 'A' , 'Ä' => 'A' , 'Å' => 'A' , 'Æ' => 'AE' , 'Ç' => 'C' ,
                'È' => 'E' , 'É' => 'E' , 'Ê' => 'E' , 'Ë' => 'E' , 'Ì' => 'I' , 'Í' => 'I' , 'Î' => 'I' , 'Ï' => 'I' ,
                'Ð' => 'D' , 'Ñ' => 'N' , 'Ò' => 'O' , 'Ó' => 'O' , 'Ô' => 'O' , 'Õ' => 'O' , 'Ö' => 'O' , 'Ő' => 'O' ,
                'Ø' => 'O' , 'Ù' => 'U' , 'Ú' => 'U' , 'Û' => 'U' , 'Ü' => 'U' , 'Ű' => 'U' , 'Ý' => 'Y' , 'Þ' => 'TH' ,
                'ß' => 'ss' ,
                'à' => 'a' , 'á' => 'a' , 'â' => 'a' , 'ã' => 'a' , 'ä' => 'a' , 'å' => 'a' , 'æ' => 'ae' , 'ç' => 'c' ,
                'è' => 'e' , 'é' => 'e' , 'ê' => 'e' , 'ë' => 'e' , 'ì' => 'i' , 'í' => 'i' , 'î' => 'i' , 'ï' => 'i' ,
                'ð' => 'd' , 'ñ' => 'n' , 'ò' => 'o' , 'ó' => 'o' , 'ô' => 'o' , 'õ' => 'o' , 'ö' => 'o' , 'ő' => 'o' ,
                'ø' => 'o' , 'ù' => 'u' , 'ú' => 'u' , 'û' => 'u' , 'ü' => 'u' , 'ű' => 'u' , 'ý' => 'y' , 'þ' => 'th' ,
                'ÿ' => 'y' ,
                // Latin symbols
                '©' => '(c)' ,
                // Greek
                'Α' => 'A' , 'Β' => 'B' , 'Γ' => 'G' , 'Δ' => 'D' , 'Ε' => 'E' , 'Ζ' => 'Z' , 'Η' => 'H' , 'Θ' => '8' ,
                'Ι' => 'I' , 'Κ' => 'K' , 'Λ' => 'L' , 'Μ' => 'M' , 'Ν' => 'N' , 'Ξ' => '3' , 'Ο' => 'O' , 'Π' => 'P' ,
                'Ρ' => 'R' , 'Σ' => 'S' , 'Τ' => 'T' , 'Υ' => 'Y' , 'Φ' => 'F' , 'Χ' => 'X' , 'Ψ' => 'PS' , 'Ω' => 'W' ,
                'Ά' => 'A' , 'Έ' => 'E' , 'Ί' => 'I' , 'Ό' => 'O' , 'Ύ' => 'Y' , 'Ή' => 'H' , 'Ώ' => 'W' , 'Ϊ' => 'I' ,
                'Ϋ' => 'Y' ,
                'α' => 'a' , 'β' => 'b' , 'γ' => 'g' , 'δ' => 'd' , 'ε' => 'e' , 'ζ' => 'z' , 'η' => 'h' , 'θ' => '8' ,
                'ι' => 'i' , 'κ' => 'k' , 'λ' => 'l' , 'μ' => 'm' , 'ν' => 'n' , 'ξ' => '3' , 'ο' => 'o' , 'π' => 'p' ,
                'ρ' => 'r' , 'σ' => 's' , 'τ' => 't' , 'υ' => 'y' , 'φ' => 'f' , 'χ' => 'x' , 'ψ' => 'ps' , 'ω' => 'w' ,
                'ά' => 'a' , 'έ' => 'e' , 'ί' => 'i' , 'ό' => 'o' , 'ύ' => 'y' , 'ή' => 'h' , 'ώ' => 'w' , 'ς' => 's' ,
                'ϊ' => 'i' , 'ΰ' => 'y' , 'ϋ' => 'y' , 'ΐ' => 'i' ,
                // Turkish
                'Ş' => 'S' , 'İ' => 'I' , 'Ç' => 'C' , 'Ü' => 'U' , 'Ö' => 'O' , 'Ğ' => 'G' ,
                'ş' => 's' , 'ı' => 'i' , 'ç' => 'c' , 'ü' => 'u' , 'ö' => 'o' , 'ğ' => 'g' ,
                // Russian
                'А' => 'A' , 'Б' => 'B' , 'В' => 'V' , 'Г' => 'G' , 'Д' => 'D' , 'Е' => 'E' , 'Ё' => 'Yo' , 'Ж' => 'Zh' ,
                'З' => 'Z' , 'И' => 'I' , 'Й' => 'J' , 'К' => 'K' , 'Л' => 'L' , 'М' => 'M' , 'Н' => 'N' , 'О' => 'O' ,
                'П' => 'P' , 'Р' => 'R' , 'С' => 'S' , 'Т' => 'T' , 'У' => 'U' , 'Ф' => 'F' , 'Х' => 'H' , 'Ц' => 'C' ,
                'Ч' => 'Ch' , 'Ш' => 'Sh' , 'Щ' => 'Sh' , 'Ъ' => '' , 'Ы' => 'Y' , 'Ь' => '' , 'Э' => 'E' , 'Ю' => 'Yu' ,
                'Я' => 'Ya' ,
                'а' => 'a' , 'б' => 'b' , 'в' => 'v' , 'г' => 'g' , 'д' => 'd' , 'е' => 'e' , 'ё' => 'yo' , 'ж' => 'zh' ,
                'з' => 'z' , 'и' => 'i' , 'й' => 'j' , 'к' => 'k' , 'л' => 'l' , 'м' => 'm' , 'н' => 'n' , 'о' => 'o' ,
                'п' => 'p' , 'р' => 'r' , 'с' => 's' , 'т' => 't' , 'у' => 'u' , 'ф' => 'f' , 'х' => 'h' , 'ц' => 'c' ,
                'ч' => 'ch' , 'ш' => 'sh' , 'щ' => 'sh' , 'ъ' => '' , 'ы' => 'y' , 'ь' => '' , 'э' => 'e' , 'ю' => 'yu' ,
                'я' => 'ya' ,
                // Ukrainian
                'Є' => 'Ye' , 'І' => 'I' , 'Ї' => 'Yi' , 'Ґ' => 'G' ,
                'є' => 'ye' , 'і' => 'i' , 'ї' => 'yi' , 'ґ' => 'g' ,
                // Czech
                'Č' => 'C' , 'Ď' => 'D' , 'Ě' => 'E' , 'Ň' => 'N' , 'Ř' => 'R' , 'Š' => 'S' , 'Ť' => 'T' , 'Ů' => 'U' ,
                'Ž' => 'Z' ,
                'č' => 'c' , 'ď' => 'd' , 'ě' => 'e' , 'ň' => 'n' , 'ř' => 'r' , 'š' => 's' , 'ť' => 't' , 'ů' => 'u' ,
                'ž' => 'z' ,
                // Polish
                'Ą' => 'A' , 'Ć' => 'C' , 'Ę' => 'e' , 'Ł' => 'L' , 'Ń' => 'N' , 'Ó' => 'o' , 'Ś' => 'S' , 'Ź' => 'Z' ,
                'Ż' => 'Z' ,
                'ą' => 'a' , 'ć' => 'c' , 'ę' => 'e' , 'ł' => 'l' , 'ń' => 'n' , 'ó' => 'o' , 'ś' => 's' , 'ź' => 'z' ,
                'ż' => 'z' ,
                // Latvian
                'Ā' => 'A' , 'Č' => 'C' , 'Ē' => 'E' , 'Ģ' => 'G' , 'Ī' => 'i' , 'Ķ' => 'k' , 'Ļ' => 'L' , 'Ņ' => 'N' ,
                'Š' => 'S' , 'Ū' => 'u' , 'Ž' => 'Z' ,
                'ā' => 'a' , 'č' => 'c' , 'ē' => 'e' , 'ģ' => 'g' , 'ī' => 'i' , 'ķ' => 'k' , 'ļ' => 'l' , 'ņ' => 'n' ,
                'š' => 's' , 'ū' => 'u' , 'ž' => 'z' ,
            ];

            // Make custom replacements
            $str = preg_replace(array_keys($options['replacements']) , $options['replacements'] , $str);

            // Transliterate characters to ASCII
            if($options['transliterate']){
                $str = str_replace(array_keys($char_map) , $char_map , $str);
            }

            // Replace non-alphanumeric characters with our delimiter
            $str = preg_replace('/[^\p{L}\p{Nd}]+/u' , $options['delimiter'] , $str);

            // Remove duplicate delimiters
            $str = preg_replace('/(' . preg_quote($options['delimiter'] , '/') . '){2,}/' , '$1' , $str);

            // Truncate slug to max. characters
            $str = mb_substr($str , 0 , ($options['limit'] ? $options['limit'] : mb_strlen($str , 'UTF-8')) , 'UTF-8');

            // Remove delimiter from ends
            $str = trim($str , $options['delimiter']);
//        $str=iconv('UTF-16LE', 'UTF-8', strrev(iconv('UTF-8', 'UTF-16BE', $str)));

            return $options['lowercase'] ? mb_strtolower($str , 'UTF-8') : $str;
        }

        static function minifyHtml($html)
        {
            $replace = [
                '/\>[^\S ]+/s'                                                      => '>',
                '/[^\S ]+\</s'                                                      => '<',
                '/([\t ])+/s'                                                       => ' ',
                '/^([\t ])+/m'                                                      => '',
                '/([\t ])+$/m'                                                      => '',
                '~//[a-zA-Z0-9 ]+$~m'                                               => '',
                '/[\r\n]+([\t ]?[\r\n]+)+/s'                                        => "\n",
                '/\>[\r\n\t ]+\</s'                                                 => '><',
                '/}[\r\n\t ]+/s'                                                    => '}',
                '/}[\r\n\t ]+,[\r\n\t ]+/s'                                         => '},',
                '/\)[\r\n\t ]?{[\r\n\t ]+/s'                                        => '){',
                '/,[\r\n\t ]?{[\r\n\t ]+/s'                                         => ',{',
                '/\),[\r\n\t ]+/s'                                                  => '),',
                '~([\r\n\t ])?([a-zA-Z0-9]+)=\"([a-zA-Z0-9_\\-]+)\"([\r\n\t ])?~s'  => '$1$2=$3$4',
            ];

            return preg_replace(array_keys($replace), array_values($replace), $html);
        }



        public static function makeDirectory($upPath)
        {
            $tags = explode('/' , str_replace('//' , '/' , $upPath));            // explode the full path
            $mkDir = "";

            foreach($tags as $folder){
                $mkDir = $mkDir . $folder . "/";   // make one directory join one other for the nest directory to make
                if(!File::exists($mkDir)){             // check if directory exist or not
                    File::makeDirectory($mkDir);
                }
            }

        }

        public static function asset($path , $secure = null)
        {
            return asset(config('Zoroaster.assets_path') . '/' . $path , $secure);
        }

        public static function replace_str_in_file($file , $str_search , $str_replace)
        {
            $app = file_get_contents($file);

            file_put_contents($file , str_replace($str_search , $str_replace , $app));
        }


    }