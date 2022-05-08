<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\UpdateUserInfoAPIRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Response;
use Carbon\Carbon;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
     /**
     * Display the specified Company.
     * GET|HEAD /getWorkDetail/{working_month}
     *
     * @param Request $request
     * @param int $working_month
     *
     * @return Response
     */
    public function getLogin(Request $request)
    {
        $data = $request->all();
        try{
            $user = DB::table('user')->where('email', $data['username'])
            ->where('password', $data['password'])
            ->first();

            return $this->sendSuccess('Login success');
        }
        catch (Exception $ex) {
            Log::error('LoginController@getLogin:' . $ex->getMessage().$ex->getTraceAsString());
            return $this->sendError(Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
