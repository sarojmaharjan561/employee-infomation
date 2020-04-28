<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});
Route::get('/employee',function(){
	return view('employee.index');
})->name('employee_index')->middleware('auth');;
Route::get('/employee/create/{id?}',function(){
	return view('employee.create');
})->name('employee_create')->middleware('auth');;
Route::get('/department',function(){
	return view('department.index');
})->name('department_index')->middleware('auth');;
Route::get('/department/create/{id?}',function(){
	return view('department.create');
})->name('department_create')->middleware('auth');;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group([ 'prefix' => 'api'], function(){
	Route::get('department','DepartmentController@index');
	Route::post('department','DepartmentController@store');
	Route::post('department/delete/{id}','DepartmentController@destroy');
	Route::get('department/edit/{id}','DepartmentController@edit');
	Route::put('department/update/{id}','DepartmentController@update');
	
	Route::get('department/list','DepartmentController@departmentList');
	
	Route::get('employee','EmployeeController@index');
	Route::post('employee/check_email','EmployeeController@checkEmail');
	Route::post('employee','EmployeeController@store');
	Route::post('employee/delete/{id}','EmployeeController@destroy');
	Route::get('employee/edit/{id}','EmployeeController@edit');
	Route::put('employee/update/{id}','EmployeeController@update');

});