<?php

Route::group(['namespace' => 'Leaderboard'], function() {
    Route::get('/', 'HomeController@index')->name('leaderboard.dashboard');
    Route::get('/admin-contacts', 'HomeController@contacts')->name('leaderboard.contacts');

    //Route Sales League
    Route::get('/competition/show-competition-league', 'SaleLeagueController@showCompetitionLeague')->name('leaderboard.show.competition.league');
    Route::get('/competition/show-competition-filename', 'SaleLeagueController@showCompetitionFilename')->name('leaderboard.show.filename');
    Route::get('/sale-logs', 'SaleLeagueController@salesLog')->name('leaderboard.sales.log');
    Route::get('/sales-league', 'SaleLeagueController@index')->name('leaderboard.sale.league.index');
    Route::post('/store', 'SaleLeagueController@store')->name('leaderboard.sale.league.store');
    Route::get('/log-sale', 'SaleLeagueController@logSale')->name('leaderboard.log.sale');
    Route::get('/sales-league/show/{id}', 'SaleLeagueController@show')->name('leaderboard.sale.league.show');
    Route::get('/sales-type', 'SaleLeagueController@salesType')->name('leaderboard.sales.type');

    //Route::get('/sales-type', 'SaleLeagueController@salesType')->name('leaderboard.sales.type');

    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('leaderboard.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('leaderboard.logout');

    // Register
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('leaderboard.register');
    Route::post('register', 'Auth\RegisterController@register');

    // Passwords
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('leaderboard.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('leaderboard.password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('leaderboard.password.reset');

    // Must verify email
    Route::get('email/resend','Auth\VerificationController@resend')->name('leaderboard.verification.resend');
    Route::get('email/verify','Auth\VerificationController@show')->name('leaderboard.verification.notice');
    Route::get('email/verify/{id}/{hash}','Auth\VerificationController@verify')->name('leaderboard.verification.verify');
});
