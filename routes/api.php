<?php

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');

Route::get('posts', 'Api\PostController@index');
Route::get('posts/{post}', 'Api\PostController@show');
Route::get('posts/{post}/comments', 'Api\CommentController@index');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('posts', 'Api\PostController@create');
    Route::put('posts/{post}', 'Api\PostController@update');
    Route::delete('posts/{post}', 'Api\PostController@delete');
    Route::post('posts/{post}/comments', 'Api\CommentController@create');
    Route::delete('posts/{post}/comments/{comment}', 'Api\CommentController@delete');

    Route::get('logout', 'Auth\LoginController@logout');
});
