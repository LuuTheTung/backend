<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companies = DB::table('company')
                        ->select('company.*', 'user.family_name', 'user.given_name', 'user.email AS admin_email')
                        ->leftJoin('user', 'user.id', '=', 'company.admin_id')
                        ->get();

        return response()->json($companies, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = $request->all();

        $companies = DB::table('company')
        ->orderBy('id', 'desc')
        ->first();

        $adminID = DB::table('user')->insertGetId([
            'mst_company_id' => $companies->id + 1,
            'family_name' => $items['family_name'],
            'given_name' => $items['given_name'],
            'email' => $items['email'],
            'password' => $items['password'],
            'phone_number' => $items['phone_number'],
            'address' => $items['address'],
            'state_flg' => $items['state_flg'],
            'start_work_date' => $items['start_work_date'],
            'user_flg' => $items['user_flg'],
            'create_at' => $items['start_work_date'],
            'create_user' => $items['create_user'],
        ]);

        $company = DB::table('company')->insert([
            'company_name' => $items['company_name'],
            'admin_id' => $adminID,
            'phone_number' => $items['phone_number_company'],
            'address' => $items['company_address'],
            'create_at' => $items['start_work_date'],
            'create_user' => $items['create_user'],
        ]);

        Log::info($adminID);
        return response()->json($companies, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companies = DB::table('company')
                        ->select('company.*', 'user.family_name', 'user.given_name', 'user.email AS admin_email', 'user.phone_number AS admin_phone_number', 'user.address AS admin_address')
                        ->where('company.id', $id)
                        ->leftJoin('user', 'user.id','=', 'company.admin_id')
                        ->first();

        return response()->json($companies, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
