<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['middleware' => ['api','CheckPassword','changeLang']],function ()
{
    Route::post('getCategories','CategoriesController@getAll');
    Route::post('getCategoryId','CategoriesController@getCategoryId');
    Route::post('getCategoryById/{id}','CategoriesController@getCategoryById');
    Route::post('updateCategoryById/{id}','CategoriesController@updateCategoryById');
    Route::post('adminLogin','AdminAuthController@adminLogin');
    Route::post('logout','AdminAuthController@logout')->middleware('auth.guard:admin-api');
    Route::post('userLogin','AdminAuthController@userLogin');
    Route::post('profile',function () {    return "hello malak" ;  })->middleware('auth.guard:user-api');

});


// return \Auth::User() ;


Route::group(['middleware' => ['api','CheckPassword','changeLang','checkAdminToken:admin-api']],function ()
{
    Route::post('offers','CategoriesController@index');
});




Route::group(['middleware'=>['api','checkPass']],function ()
{
    Route::post('getDepartments','DepartmentsController@show');
});










