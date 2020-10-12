<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'home')->name('home');


Route::middleware(['guest'])->group(function () {

	Route::get('register', 'RegisterController@showRegisterForm')->name('register');
	Route::post('register', 'RegisterController@register')->name('register');

	Route::get('login', 'LoginController@showLoginForm')->name('login');
	Route::post('login/authenticate', 'LoginController@authenticate')->name('login.authenticate');

});


Route::middleware(['auth'])->group(function () {
	
	Route::post('logout', 'LoginController@logout')->name('logout');

	Route::get('quiz', 'QuizController@index')->name('quiz');
	Route::post('quiz/{played_id}/complete', 'QuizController@submit')->name('quiz.submit');
	Route::get('quiz/{played_id}/result', 'QuizController@result')->name('quiz.result');
	
	Route::get('user/activity', 'QuizController@user')->name('user.activity');

});


Route::prefix('admin')->group(function () {

	Route::middleware(['guest:admin'])->group(function () {

		Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
		Route::post('login', 'Admin\LoginController@authenticate')->name('admin.login.authenticate');
	});

	Route::middleware(['auth:admin'])->group(function () {
		Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');

		Route::view('/', 'admin/dashboard')->name('admin.dashboard');
		
		Route::get('quiz-played', 'Admin\ReportController@quizzesPlayed')->name('report.quiz.all');
		Route::get('quiz-played/{played_id}', 'Admin\ReportController@quizSummary')->name('report.quiz');

		Route::get('quiz-users', 'Admin\ReportController@allUsers')->name('report.users');
		Route::get('quiz-users/{user}', 'Admin\ReportController@user')->name('report.user');
	});

});