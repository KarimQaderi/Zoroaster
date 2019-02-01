<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use KarimQaderi\Zoroaster\Metrics\Metric;
    use KarimQaderi\Zoroaster\Metrics\Partition;
    use KarimQaderi\Zoroaster\Metrics\Trend;
    use KarimQaderi\Zoroaster\Metrics\Value;

    class MetricController extends Controller
    {

        public function handle(Request $request)
        {
            $class = str_replace('-' , '\\' , $request->class);

            if(!class_exists($class)) return 'Metric پیدا نشد';

            if(is_null(\Zoroaster::getDashboardMetricFind(class_basename($class)))) return ' کلاس داخل داشبورد پیدا نشد';

            /** @var Metric | Value | Trend | Partition $newClass */
            $newClass = new $class;


            if($newClass->authorizedToSee())
                return [
                    'class' => $request->class ,
                    'html' => \Zoroaster::minifyHtml(view('Zoroaster::metrics.' . array_first(explode('-' , $newClass->component)))->with(
                        array_merge((array) $newClass->calculate($request) , [
                        'class' => $class ,
                        'classN' => str_replace('\\' , '_' , $class) ,
                        'ranges' => method_exists($newClass , 'ranges') ? $newClass->ranges() : null ,
                        'label' => $newClass->label() ,
                        'range' => $request->range ,
                    ]))->render())
                ];

//            return response()->json((array)(new $class)->calculate($request));

        }


    }