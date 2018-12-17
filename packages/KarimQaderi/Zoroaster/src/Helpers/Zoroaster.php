<?php


    use App\Zoroaster\Other\Dashboard;
    use App\Zoroaster\Other\Navbar;
    use App\Zoroaster\Other\Sidebar;
    use Illuminate\Support\Facades\File;
    use KarimQaderi\Zoroaster\Builder;
    use KarimQaderi\Zoroaster\ResourceFilters\DefaultFilters;
    use KarimQaderi\Zoroaster\Zoroaster as SrcZoroaster;


    class Zoroaster
    {
        use Builder;


        public static function Filters($request)
        {
            $Filters = null;
            $filters = array_reverse((new DefaultFilters())->hendle());
            if($request->Resource()->filters() != null)
                $filters = array_merge($filters , $request->Resource()->filters());

            foreach($filters as $filter){
                if($filter->canSee($request))
                    $Filters .= $filter->render($request)->render();
            }

            return $Filters;

        }

        public static function ResourceActions($request , $data , $model , $view , $field = null)
        {
            $Actions = null;
            foreach($request->Resource()->ResourceActions() as $Action){
                if($Action->{'showFrom' . $view} == true && $Action->Authorization($request , $data))
                    $Actions .= $Action->render($request , $data , $model , $view , $field);

            }

            return $Actions;
        }

        public static function Sidebar()
        {
            return self::RenderViewForm(Sidebar::handle() ,
                function($field){
                    return true;
                } ,
                'viewDetail' , null , null);
        }

        /**
         * @param string $position left || right || center
         * @return null|string
         */
        public static function Navbar($position = 'left')
        {
            return self::RenderViewForm(Navbar::$position() ,
                function($field){
                    return true;
                } ,
                'viewDetail' , null , null);
        }

        public static function Widgets()
        {
            return self::RenderViewForm(Dashboard::handle() ,
                function($field){
                    return true;
                } ,
                'viewDetail' , null , null);
        }


        public static function newResourceByModelName($modelName)
        {
            $resource = self::getFullNameResourceByModelName($modelName);
            if(class_exists($resource))
                return new $resource;
            else
                return null;
        }

        public static function newModel($model)
        {
            return SrcZoroaster::newModel($model);
        }

        public static function newResourceByResourceName($ResourceName)
        {
            return SrcZoroaster::newResource($ResourceName);
        }

        public static function getFieldResource($Resource , $field)
        {
            if(is_string($Resource))
                $Resource = SrcZoroaster::newResource($Resource);

            if($Resource === null)
                throw new Exception ('Resource پیدا نشد');


            return self::ResourceFieldFind($field , $Resource->fields());
        }

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

        public static function getFullNameResourceByModelName($modelName)
        {
            return config('Zoroaster.Resources') . self::getNameResourceByModelName($modelName);
        }

        public static function getNameResourceByModelName($modelName)
        {
            return array_last(explode('\\' , $modelName));
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

        static function url_slug($str , $options = array())
        {
            // Make sure string is in UTF-8 and strip invalid UTF-8 characters
            $str = mb_convert_encoding((string)$str , 'UTF-8' , mb_list_encodings());

            $defaults = array(
                'delimiter' => '-' ,
                'limit' => null ,
                'lowercase' => true ,
                'replacements' => array() ,
                'transliterate' => false ,
            );

            // Merge options
            $options = array_merge($defaults , $options);

            $char_map = array(
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
                'š' => 's' , 'ū' => 'u' , 'ž' => 'z'
            );

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


        static function sizeInBytesToReadable($size)
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

    }