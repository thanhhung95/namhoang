<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('diadanh/{parent_id}',function ($parent_id){
    $rows = DB::table('dm_diadanh')
        ->where('id_parent',$parent_id)
        ->orderBy('ordering','asc')
        ->select('id','ten')
        ->get();
    return response()->json($rows);
});
Route::post('filter','Api\FilterController@Show');