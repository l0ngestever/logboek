<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/login', 'UsersController@login');

Route::group(['before' => 'auth'], function() {
    Route::get('/', 'EntriesController@index');
    Route::get('/intro', 'DashboardController@intro');

    Route::resource('logbooks', 'LogbooksController');
    Route::resource('logbooks.entries', 'EntriesController');
    Route::get('/entries', 'EntriesController@index');
    Route::resource('users', 'UsersController');
    Route::resource('tasks', 'TasksController');
    Route::resource('evidences', 'EvidenceController');
    Route::resource('files', 'FilesController');
    Route::get('/files/{id}/download', 'FilesController@download');

    Route::post('/tasks/{id}/toggle', 'TasksController@toggle');

    Route::any('/logout', 'UsersController@logout');
});
