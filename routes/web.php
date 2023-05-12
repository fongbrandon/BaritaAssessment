<?php

use App\Securities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Coupons;
use App\StatusCodes;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/create_coupon', function (Request $request) {
    if($request->filled('id')){
    return view('create_coupon')->with('Securities',Securities::get())
    ->with('Coupon',Coupons::where('coupon_id',$request->input('id'))->first());
    }else{
        return view('create_coupon')->with('Securities',Securities::get());
    }
})->name('create_coupon');
Route::post('/submit_coupon', function (Request $request) {
    $coupon = new Coupons();
    $coupon->isin_code = $request->input('isin_code');
    $coupon->payment_date = $request->input('payment_date');
    $t=time();
    $coupon->record_date=date("Y-m-d",$t);
    $coupon->status_id=1;
    $coupon->save();
    return redirect('/');
})->name('submit_coupon');

// Route::delete('/', function(Request $request){
//     // If the coupon is found delete it
//     if($request->filled('id') && $request->input('delete')){
//         $id = $request->filled('id');
//         Coupons::find($id)->delete();
//     }
//     // No matter what, return to the home view
//     $coupons = DB::table('coupons')->get();
//     $status = DB::table('status_codes')->get();
//     $securities = DB::table('securities')->get();
//     return view('view_coupon', ['coupons' => $coupons,'statuses'=>$status,'securities'=>$securities]);
// })->name('delete_coupon');

// View Coupon Page
Route::get('/', function (Request $request) {
    if($request->filled('id') && $request->input('method') == 'delete'){
        $coupon = Coupons::where('coupon_id', $request->input('id'))->first();
        if($coupon){
            DB::table('coupons')->where('coupon_id',$coupon->coupon_id)->delete();
        }
        // $coupon = Coupons::where('coupon_id',$id)->first();
    }
 
    if($request->filled('id') && $request->input('method') == 'approve'){
        $coupon = Coupons::where('coupon_id', $request->input('id'))->first();
        if($coupon){
            DB::table('coupons')->where('coupon_id', $coupon->coupon_id)->update(['status_id' => 2]);
        }
        // $coupon = Coupons::where('coupon_id',$id)->first();
    }

    if($request->filled('id') && $request->input('method') == 'cancel'){
        $coupon = Coupons::where('coupon_id', $request->input('id'))->first();
        if($coupon){
            DB::table('coupons')->where('coupon_id', $coupon->coupon_id)->update(['status_id' => 3]);
        }
        // $coupon = Coupons::where('coupon_id',$id)->first();
    }
    $coupons = DB::table('coupons')->get();
    $status = DB::table('status_codes')->get();
    $securities = DB::table('securities')->get();
    return view('view_coupon', ['coupons' => $coupons,'statuses'=>$status,'securities'=>$securities]);
})->name('index');

Route::get('get_coupon_information', function(Request $request){
    return Coupons::where('coupon_id',$request->input('id'))->first();
    // $coupons = DB::table('coupons')->where('id',$request->id)->get();
})->name('get_coupon_information');
