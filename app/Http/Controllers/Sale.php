<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Models\SaleProduct;
class Sale extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request , $type = '')
    {
        // if(DB::connection()->getDatabaseName())
        // {
        //     echo "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
        // }else{
        //     echo 'Connection False !!';
        // }
        // $sale = DB::table('sale_product')->get();
        // echo '<pre>';
        // print_r(json_decode($sale));
        // exit;
        if($type == 'getdata'){
            $sale = json_decode(SaleProduct::select(DB::raw('*,((saleprice - buyprice) - tranprice) as profit'))->orderBy('id','desc')->get()); //DB::table('sale_product')->get();

            return response()->json($sale);

        }else if($type == 'mangedata'){
            $type   = $request->input('type');
            $data    = (object) $request->input('obj');
            $status = "fail";

            if($type == "insert"){
                SaleProduct::create([
                    'productname'   => $data->productname,
                    'buyprice'      => $data->buyprice,
                    'saleprice'     => $data->saleprice,
                    'tranprice'     => $data->tranprice,
                    'buydate'       => $data->buydate,
                    'saledate'      => $data->saledate
                ]);
                $status = "success";

            }else if($type == "update"){
                SaleProduct::where('id', $data->id)->update([
                    'productname'   => $data->productname,
                    'buyprice'      => $data->buyprice,
                    'saleprice'     => $data->saleprice,
                    'tranprice'     => $data->tranprice,
                    'buydate'       => $data->buydate,
                    'saledate'      => $data->saledate
                ]);
                $status = "success";

            }

            return response()->json(["status" => $status]);

        }else{
            return view('sale.index');
        }
    }
}
