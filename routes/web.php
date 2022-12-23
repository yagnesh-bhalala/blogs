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

Route::get('image/{any1?}/{any2?}/{any3?}', 'HomeController@image');
Route::any('image-upload','HomeController@imageUpload');


Route::prefix('/admin')->namespace('Admin')->group(function(){
    //Login
    Route::match(['get','post'],'/','AdminController@login');
    
    Route::group(['middleware' => 'adminMiddleware'],function() {
        //Logout
        Route::get('/logout','AdminController@logout')->name('admin.logout');
        //Dashboard
        Route::match(['get','post'],'/dashboard','AdminController@dashboard')->name('admin.home');      

        // User Contact List
        Route::get('get-contact','AdminController@getUserContact');
        Route::match(['get','post'],'delete-user-contact/{id}','AdminController@deleteUserContact');

        //articles
        Route::match(['get','post'],'get-articles','ArticlesController@getArticles')->name('get-articles');
        Route::match(['get','post'],'add-edit-article/{id?}','ArticlesController@addEditArticle')->name('add-edit-article');
        // Route::post('update-blog-status','ArticlesController@updateBlogStatus');
        Route::match(['get','post'],'delete-article/{id}','ArticlesController@deleteArticle')->name('delete-article');
    });
});


Route::group(['namespace' => 'Front',], function() {    
    Route::get('/','FrontController@dashboard');
    Route::get('blogs','FrontController@blogs');
    Route::get('blog-details/{any}','FrontController@blogDetails');

    Route::get('articles','FrontController@articles');
    Route::get('article-details/{any}','FrontController@articleDetails');
    Route::match(['get','post'],'getBlogListRequestAjax','FrontController@getBlogListRequest'); // ajax
});

Auth::routes();