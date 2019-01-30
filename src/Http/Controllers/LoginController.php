<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Foundation\Validation\ValidatesRequests;

    class LoginController extends Controller
    {

        use AuthenticatesUsers, ValidatesRequests;


        public function __construct()
        {
            $this->middleware('web');
        }

        public function showLoginForm()
        {
            return view('Zoroaster::auth.login');
        }


        public function redirectPath()
        {
            return url(config('Zoroaster.path'));
        }


    }