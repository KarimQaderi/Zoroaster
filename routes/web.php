<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */


    use App\models\Post;
    use Illuminate\Support\Facades\Auth;

    Auth::routes();

//    Route::get('/home' , 'HomeController@index')->name('home');

    Auth::loginUsingId(1);




    Route::get('/svgr' , function(){
        $html=null;
        foreach(glob(public_path('svgs') . '/*.svg') as $file){
            $basename = str_replace_last('.svg' , '' , basename($file));
            $basename = str_replace_first('icon-' , '' , $basename);
            $svg = str_replace(' xmlns="http://www.w3.org/2000/svg"' , '' , file_get_contents(($file)));
            $svg = str_replace(' class="heroicon-ui"' , '' , $svg);
            $svg = str_replace('"' , '\"' , $svg);

            $old_txt = file_get_contents(public_path('svgs/icon.txt'));

            if(str_contains($old_txt , $basename))
                $basename = $basename . '-2';

            file_put_contents(public_path('svgs/icon.txt') , file_get_contents(public_path('svgs/icon.txt')) . '"' . $basename . '":"' . $svg . '",' . PHP_EOL);

            $html.="<li><span class=\"uk-margin-small-right\" uk-icon=\"$basename\"></span> $basename</li>". PHP_EOL;
        }

        echo $html;

    });