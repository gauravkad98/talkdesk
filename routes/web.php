<?php

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










Route::get('/', function () {
    return view('auth/login');
});






Auth::routes();




Route::get('/home', 'HomeController@index')->name('home');

//Update status
Route::post('/on_off_status_update', 'talkdesk@on_off')->name('talkdesk.on_off_status_update');

Route::get('/paginate', 'talkdesk@paginate')->name('user.paginate');








Route::get('/editCarrier',function () {
    return view('editCarrier');
})->name('editCarrier');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/bulkUpload',function () {
    return view('home');
})->name('bulkupload');


Route::post('/addSingleCarrier', 'Carrier@addSingleCarrier')->name('user.addSingleCarrier');

Route::post('/addCarriers', 'Carrier@addCarriers')->name('user.addcarriers');

Route::post('/updateCarriers', 'Carrier@getCarrierDetails')->name('user.updatecarriers');
Route::post('/getCarrier', 'Carrier@getCarrier')->name('user.getCarrier');
Route::post('/updateCarrier', 'Carrier@updateCarrier')->name('user.updateCarrier');

Route::post('/delectCarrier', 'Carrier@delectCarrier')->name('user.delectCarrier');
Route::post('/exportAllCarrier', 'Carrier@exportAllCarrier')->name('user.exportAllCarrier');



Route::post('/getCarrierWithCarrierCode', 'Carrier@getCarrierWithCarrierCode')->name('user.getCarrierWithCarrierCode');


Route::post('/dropCarrier', 'Carrier@dropCarrier')->name('user.dropCarrier');
