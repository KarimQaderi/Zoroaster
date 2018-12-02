<?php

    namespace App\Http\Controllers\back;


    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use KarimQaderi\Zoroaster\Fields\boolean;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\Group\RowOneCol;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Image;
    use KarimQaderi\Zoroaster\Fields\Other\Builder;
    use KarimQaderi\Zoroaster\Fields\Other\Model;
    use KarimQaderi\Zoroaster\Fields\Relations\BelongsTo;
    use KarimQaderi\Zoroaster\Fields\Text;
    use KarimQaderi\Zoroaster\Fields\Textarea;


    class PostController extends Controller
    {

        public $model = 'App\Models\Post';
        private $Builder = null;

        public function __construct()
        {
            $this->Builder = new Builder($this->model , $this->fields());
        }


        function index()
        {
            return view('BuilderFields::back.BuilderField.index')->with([
                'datas' => Model::make($this->model)->paginate() ,
                'fields' => $this->Builder->getFieldsViewIndex() ,
//                'ActionButtonRow' => $this->ActionButtonRow() ,
                'model' => Model::make($this->model) ,
            ]);

        }

        function edit($id)
        {
            return view('BuilderFields::back.BuilderField.Form')->with([
                'fields' => $this->Builder->getFieldsViewForm($id) ,
                'model' => Model::make($this->model) ,
                'id' => $id ,
                'method' => 'PUT' ,
                'route' => 'back.post.update' ,
            ]);
        }

        function create()
        {
            return view('BuilderFields::back.BuilderField.Form')->with([
                'fields' => $this->Builder->getFieldsViewForm() ,
                'model' => Model::make($this->model) ,
                'method' => 'POST' ,
                'route' => 'back.post.store' ,
            ]);
        }

        function update(Request $request , $id)
        {

            $this->Builder->BuilderFieldsSave($request , $id);

            return back()->with([
                'success' => 'اطلاعات ذخیره شد'
            ]);


        }

        function store(Request $request)
        {


            $data = $this->Builder->BuilderFieldsSave($request);

            return redirect(route('back.post.edit' , $data->{Model::make($this->model)->getPrimaryKey()}))->with([
                'success' => 'اطلاعات اضافه شد'
            ]);


        }



        public function fields()
        {

            return [

                new Row([
                    new Col('uk-width-2-3' , [
                        new Panel('' , [

                            new RowOneCol([
                                ID::make()->rules('required')->onlyOnIndex() ,
                            ]) ,

                            new Row([
                                new Col('uk-width-1-2' , [
                                    Text::make('عنوان پست' , 'title')
                                        ->help('عنوان اصلی پست برای نمایش پست')
                                        ->rules('required') ,
                                ]) ,

                                new Col('uk-width-1-2' , [
                                    Text::make('slug' , 'slug')->rules('required') ,
                                ]) ,

                            ]) ,

                            new RowOneCol([
                                Textarea::make('متن پست' , 'body')->rows(10)->onlyOnForms()->onlyOnDetail()->rules('required') ,
                            ]) ,

                            new RowOneCol([
                                Image::make('عکس پست' , 'img')->urlUpload('posts')->resize([
                                    'small' => [
                                        'w' => 200 ,
                                        'h' => 300 ,
                                    ] , 'small_2' => [
                                        'w' => 20 ,
                                        'h' => 30 ,
                                    ]
                                ]) ,
                            ]) ,

                            new RowOneCol([
                                Image::make('گالری' , 'img_multi')->urlUpload('posts')->multiImage(5)->resize([
                                    'small' => [
                                        'w' => 200 ,
                                        'h' => 300 ,
                                    ] , 'small_2' => [
                                        'w' => 20 ,
                                        'h' => 30 ,
                                    ]
                                ]) ,
                            ]) ,


                        ]) ,

                    ]) ,


                    new Col('uk-width-1-3' , [
                        new Panel('مشخصات' , [

                            new Row([
                                new Col('uk-width-1-2' , [
                                    boolean::make('نمایش پست' , 'is_published') ,
                                ]) ,
                                new Col('uk-width-1-2' , [
                                    boolean::make('پست ثابت' , 'featured') ,
                                ]) ,

                            ]) ,

                            new RowOneCol([
                                BelongsTo::make('نام کاربر' , 'user_id' , 'App\User')
                                    ->displayTitleField('name')
                                    ->routeShow('back.user.edit') ,
                            ]) ,

                            new RowOneCol([
                                Text::make('created_at' , 'created_at') ,
                            ]) ,

                            btnSave::make() ,

                        ]) ,
                    ]) ,
                ]) ,


            ];
        }

    }
