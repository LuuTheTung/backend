<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\UpdateUserInfoAPIRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Response;
use Carbon\Carbon;
class LoginController extends Controller
{
     /**
     * Display the specified Login.
     * GET|HEAD /login
     *
     * @param Request $request
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
            if(!empty($user)){
                return response()->json($user, 200);
            }
        }
        catch (Exception $ex) {
            Log::error('LoginController@getLogin:' . $ex->getMessage().$ex->getTraceAsString());
            return $this->sendError(Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
