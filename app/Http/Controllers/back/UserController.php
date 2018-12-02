<?php

    namespace App\Http\Controllers\back;


    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Image;
    use KarimQaderi\Zoroaster\Fields\Relations\BelongsTo;
    use KarimQaderi\Zoroaster\Fields\Other\Builder;
    use KarimQaderi\Zoroaster\Fields\Other\Model;
    use KarimQaderi\Zoroaster\Fields\Select;
    use KarimQaderi\Zoroaster\Fields\Text;

    class UserController extends Controller
    {

        public $model = 'App\user';
        private $Builder = null;

        public function __construct()
        {
            $this->Builder = new Builder($this->model , $this->fields());
        }


        function index()
        {

            return view('BuilderFields::back.BuilderField.index')->with([
                'data' => Model::make($this->model)->paginate() ,
                'fields' => $this->Builder->getFieldsViewIndex() ,
                'ActionButtonRow' => $this->ActionButtonRow() ,
                'primaryKey' => Model::make($this->model)->getPrimaryKey() ,
            ]);

        }

        function edit($id)
        {
            return view('BuilderFields::back.BuilderField.Form')->with([
                'fields' => $this->Builder->getFieldsViewForm($id) ,
                'primaryKey' => Model::make($this->model)->getPrimaryKey() ,
                'id' => $id ,
                'method' => 'PUT' ,
                'route' => 'back.user.update' ,
            ]);
        }

        function create()
        {
            return view('BuilderFields::back.BuilderField.Form')->with([
                'fields' => $this->Builder->getFieldsViewForm() ,
                'primaryKey' => Model::make($this->model)->getPrimaryKey() ,
                'method' => 'POST' ,
                'route' => 'back.user.store' ,
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

            return redirect(route('back.user.edit' , $data->{Model::make($this->model)->getPrimaryKey()}))->with([
                'success' => 'اطلاعات  اضافه شد'
            ]);


        }

        function ActionButtonRow()
        {
            return [
                [
                    'label' => 'ویرایش' ,
                    'route' => 'back.user.edit' ,
                    'atter' => [
                        'class' => 'uk-button uk-button-primary'
                    ] ,
                ] , [
                    'label' => 'حذف' ,
                    'route' => 'back.user.destroy' ,
                    'atter' => [
                        'class' => 'uk-button uk-button-danger'
                    ] ,
                ]
            ];
        }

        public function fields()
        {

            return [

                new Row([
                    new Col('uk-width-2-3' , [
                        new Panel('title' , [

                            ID::make()->rules('required')->onlyOnIndex() ,
                            Text::make('نام' , 'name')->rules('required') ,
                            Image::make('عکس کاربر' , 'avatar')->urlUpload('users')->multiImage()->resize([
                                'small' => [
                                    'w' => 200 ,
                                    'h' => 300 ,
                                ] , 'small_2' => [
                                    'w' => 20 ,
                                    'h' => 30 ,
                                ]
                            ]) ,

                            Text::make('ایمیل' , 'email')->rules('required' , 'max:255') ,
                            Text::make('رمز کاربر' , 'password')->rules('required') ,
                        ])
                    ]) ,

                    new Col('uk-width-1-3' , [
                        new Panel('مشخصات' , [
                            Select::make('is_admin' , 'is_admin')->options([
                                '1' => 'Admin' ,
                                '0' => 'User' ,
                            ]) ,
                            Text::make('created_at' , 'created_at') ,
                            btnSave::make() ,
                        ])
                    ])
                ]) ,


            ];
        }

    }
