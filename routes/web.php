<?php
Use App\Book;
Use App\TypeBook;
Use App\Category;
Use App\Field;
Use App\Producer;
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
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    //return "Clear Cache OK";
    // return what you want
});


Route::get('update',function(){
	$temp = Book::where('type_book','SACHNGOAI')->get();
	foreach($temp as $value){
		$value->price = 0;
		$value->save();
	}
});

Route::get('del',function(){
	$temp = Book::where('status','=',1)->delete();
	$temp = TypeBook::where('status','=',1)->delete();
	$temp = Category::where('status','=',1)->delete();
	$temp = Field::where('status','=',1)->delete();
	$temp = Producer::where('status','=',1)->delete();
});
	
Route::get('del-ngoai',function(){
	$temp = Book::where('type_book','SACHNGOAI')->delete();
});

Route::get('del-field',function(){
	$temp	= 	Book::where('field','PROFESSIONAL')->delete();
});


//trang chủ
Route::get('/','HomeController@index')->name('index');

Route::resource('/book','BookController');
 

//============== EXCELL=======================================
Route::post('/import','Excell\ImportController@Import')->name('import');
Route::get('export/{id}/{type}','Excell\ExportController@show')->name('export');

//============== ROUTE KHACH==============================
Route::group(['middleware'=>'LoginMiddleware'],function(){  
	Route::get('logout',function (){
		Auth::logout();
		return redirect('/');
	})->name('logout');

	Route::resource('cart','CartController');
	Route::resource('checkout','CheckOutController');
	// Thông tin User
	Route::group(['prefix' => 'user'],function(){
		Route::resource('purchase','UserPurchaseController');
		Route::resource('profile','UserProfileController');
	});
});
//============== ROUTE ADMIN==============================
Route::group(['middleware'=>'AdminMiddleware'],function(){			
	Route::group(['prefix' => 'admin'],function(){
		Route::resource('user-manage','Admin\UserManageController');
		Route::resource('field-manage','Admin\FieldManageController');
		Route::resource('category-manage','Admin\CategoryManageController');
		Route::resource('typebook-manage','Admin\TypeBookManageController');
		Route::resource('producer-manage','Admin\ProduceManageController');
		Route::resource('bill-manage','Admin\BillManageController');
	});
});

//login
Route::resource('login','LoginController');

// loginFacebook
Route::get('facebook/redirect', 'Auth\FacebookController@redirectToProvider');
Route::get('facebook/callback', 'Auth\FacebookController@handleProviderCallback');

//FbAccountKit
Route::resource('accountkit/callback','Auth\AccountKitController');

// loginGoogle
Route::get('google/redirect', 'Auth\GoogleController@redirectToProvider');
Route::get('google/callback', 'Auth\GoogleController@handleProviderCallback');


Route::post('user/upload','Excell\ImportController@Import');