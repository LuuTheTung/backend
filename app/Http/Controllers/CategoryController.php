<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Model\Category;
use Illuminate\Support\Facades\Log;
class CategoryController extends Controller
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $categories = DB::table('category')->get();

        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = DB::table('category')->where('id', $id)->first();

        return response()->json($category, 200);
    }

    public function getPrice($category_name)
    {
        $category = DB::table('category')->where('category_name', $category_name)->first();

        return response()->json($category, 200);
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
        }
        else {
            $dataCategory = DB::table('category')->insert($request->all());
            return response()->json(['status' => true, 'message' => [__('Create Category Success!')]]);
        }   

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        $validator = Validator::make($data, $this->model->rules());
        if ($validator->fails())
        {
            $message = $validator->messages();
            $message_all = $message->all();
            Log::info($message_all);
            return response()->json(['status' => false, 'message' => $message_all]);
        }
        else {
            $dataCategory = DB::table('category')->where('id', $id)->update($request->all());
            return response()->json(['status' => true, 'message' => [__('Update Category Success!')]]);
        }   

    }
}
