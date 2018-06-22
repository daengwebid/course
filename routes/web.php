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
    return view('welcome');
});

Route::get('/student/register', 'StudentController@register')->name('student.register');
Route::post('/student/register', 'StudentController@registered')->name('student.registered');
Route::get('/student/login', 'StudentController@showFormLogin')->name('student.form_login');
Route::post('/student/login', 'StudentController@login')->name('student.login');

Route::group(['middleware' => 'student'], function() {
    Route::get('/student/home', 'StudentController@dashboard')->name('student.dashboard');
    Route::post('/student/enroll', 'StudentController@enrollCourse')->name('student.enroll');

    Route::get('/student/my-course', 'StudentController@myCourse')->name('student.my_course');
    Route::get('/student/logout', 'StudentController@logout')->name('student.logout');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('instructor', 'InstructorController')->except([
        'create', 'show'  
    ]);
    Route::resource('course', 'CourseController')->except([
        'show'  
    ]);

    Route::get('order', 'OrderController@index')->name('order.index');
    Route::get('/order/accept', 'OrderController@acceptOrder')->name('order.accept');
    Route::delete('/order/accept/{id}', 'OrderController@changeStatus')->name('order.change_status');
});
