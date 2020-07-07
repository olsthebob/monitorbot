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

//Route::get('/', 'DashboardController@index');

Auth::routes();

/* Custom Invite Route */
Route::get('/invite', 'Auth\RegisterController@showRegistrationForm');

Route::group(['middleware' => ['has_organisation']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    //Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

/* Site Routes */
Route::get('/site/{site}', 'SitesController@show')->name('show_site');
Route::get('/site/{site}/edit', 'SitesController@edit')->name('edit_site');
Route::post('/site/{site}/update', 'SitesController@update')->name('update_site');
Route::post('/site/create', 'SitesController@store')->name('create_site');

/* Test Routes */
Route::get('/test/{test}/edit', 'TestController@edit')->name('edit_test');
Route::post('/test/{test}/update', 'TestController@update')->name('update_test');
Route::post('/test/create', 'TestController@store')->name('create_test');

/* Issue Routes */
// Route::get('/issue/{id}', 'IssuesController@show')->name('show_issue');
// Route::get('/issue/edit/{id}', 'IssuesController@edit')->name('edit_issue');
// Route::post('/issue/update/{id}', 'IssuesController@update')->name('update_issue');
// Route::post('/issue/create/{site_id}', 'IssuesController@store')->name('create_issue');


/* Organisation Routes */
Route::get('/organisation/new', 'OrganisationController@new')->name('new_organisation');
Route::post('/organisation/create/{user_id}', 'OrganisationController@store')->name('create_organisation');

/* Monitor Test */
//Route::get('/monitor', 'MonitorController@index');
