<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Model\User;
use Illuminate\Support\Facades\Validator;
class CustomerController extends Controller
{
    protected $customerService;
  
    public function __construct(CustomerService $customerService, User $model)
    {
        $this->model = $model;
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = DB::table('user')->get();

        return response()->json($customers, 200);
    }

    public function show($id)
    {
        $dataCustomer = DB::table('user')->where('id', $id)->first();

        return response()->json($dataCustomer, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->model->rules());
        if ($validator->fails())
        {
            $message = $validator->messages();
            $message_all = $message->all();
            Log::info($message_all);
            return response()->json(['status' => false, 'message' => $message_all]);
            // return response()->json(['status' => false,'message' => $message_all]);
        }
        else {
            $dataCustomer = DB::table('user')->insert($request->all());
            return response()->json(['status' => true, 'message' => [__('Create User Success!')]]);
        }       
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        $validator = Validator::make($data, $this->model->rules($id, true));
        if ($validator->fails())
        {
            $message = $validator->messages();
            $message_all = $message->all();
            Log::info($message_all);
            return response()->json(['status' => false, 'message' => $message_all]);
        }
        else {
            $dataCustomer = DB::table('user')->where('id', $id)->update($request->all());
            return response()->json(['status' => true, 'message' => [__('Update User Success!')]]);
        }       
    
    }

    public function destroy($id)
    {
        $dataCustomer = $this->customerService->destroy($id);

        return response()->json($dataCustomer['message'], $dataCustomer['statusCode']);
    }
}
