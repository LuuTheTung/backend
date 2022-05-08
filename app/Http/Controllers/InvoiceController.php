<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = DB::table('invoice')->get();

        return response()->json($invoices, 200);
    }

    public function getListInvoice($create_user)
    {
        Log::info($create_user);
        $invoices = DB::table('invoice')
            ->where('create_user', $create_user)
            ->orderBy('invoice_id', 'desc')
            ->get();

        return response()->json($invoices, 200);
    }

    public function getListUser($create_user)
    {
        Log::info($create_user);
        $users = DB::table('user')
            ->where('create_user', $create_user)
            ->where('user_flg','=', 1)
            ->orderBy('start_work_date', 'desc')
            ->get();

        return response()->json($users, 200);
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
        $totalPrice = 0;

        $createTime = Carbon::now('Asia/Ho_Chi_Minh');
        $invoiceID = Carbon::now('Asia/Ho_Chi_Minh')->format('\HYmdHisu');
        $month_income = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        foreach ($items as $item){
            DB::table('invoice_item')->insert([
                'invoice_id' => $invoiceID,
                'category_id' => $item['category_id'],
                'category_name' => $item['category_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'create_at' => $createTime,
                'create_user' => $item['create_user'],
            ]);
            $totalPrice = ($item['quantity'] * $item['price']) + $totalPrice;
        }
        DB::table('invoice')->insert([
            'invoice_id' => $invoiceID,
            'total_price' => $totalPrice,
            'create_at' => $createTime,
            'create_user' => $item['create_user'],
        ]);
        $company_detail = DB::table('company')
            ->where('id', $item['mst_company_id'])
            ->first();

        $income_detail = DB::table('income_statement')
            ->where('create_user', $item['create_user'])
            ->where('month_income', $month_income)
            ->first();
        if ($income_detail) {
            Log::info('exist');
            DB::table('income_statement')->where('month_income', $month_income)
                ->where('create_user', $item['create_user'])
                ->update([
                    'total_invoice' => $income_detail->total_invoice + 1,
                    'income' => $totalPrice + $income_detail->income,
                    'update_at' => $createTime,
                    'update_user' => $item['create_user'],
                ]);
        }
        else {
            DB::table('income_statement')->insert([
                'mst_company_id' => $item['mst_company_id'],
                'admin_id' => $company_detail->admin_id,
                'user_id' => $item['user_id'],
                'total_invoice' => 1,
                'month_income' =>$month_income,
                'income' => $totalPrice,
                'create_at' => $createTime,
                'create_user' => $item['create_user'],
            ]);
        }
        return response()->json( 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = DB::table('invoice')
                    ->select('invoice.invoice_id', 'invoice.total_price', 'invoice_item.*')
                    ->where('invoice.id', $id)
                    ->leftJoin('invoice_item', 'invoice.invoice_id', '=', 'invoice_item.invoice_id')
                    ->get();

        return response()->json($invoice, 200);
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

    public function getTodayIncome($create_user)
    {
        Log::info($create_user);
        $month_income = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $invoices = DB::table('income_statement')
            ->where('create_user', $create_user)
            ->where('month_income', $month_income)
            ->first();

        return response()->json($invoices, 200);
    }

    public function getCurrentMonth($create_user)
    {
        Log::info($create_user);
        $month_income = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m');
        $invoices = DB::table('income_statement')
            ->where('create_user', $create_user)
            ->where('month_income', 'like', "%$month_income%")
            ->select(DB::raw("SUM(total_invoice) as totalInvoice, SUM(income) as totalIncome"))
            ->first();

        return response()->json($invoices, 200);
    }

    public function getLastestInvoice($create_user)
    {
        Log::info($create_user);
        $invoices = DB::table('invoice')
            ->where('create_user', $create_user)
            ->orderBy('invoice_id', 'desc')
            ->first();

        return response()->json($invoices, 200);
    }
}
