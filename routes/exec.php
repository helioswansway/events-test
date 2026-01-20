<?php

Route::group([
    'namespace' => 'Exec',
    //'middleware' => 'auth:exec', //Redirects to /login
    // 'middleware' => 'exec.verified' //Redirects to /login
    // 'middleware' => 'exec.guest', // returns error "Attempt to read property "password_changed_at" on null"
], function() {


        Route::middleware(['exec_password_expired'])->group(function () {});

        Route::get('/', 'HomeController@index')->name('exec.dashboard');
        Route::get('/dashboard', 'HomeController@index')->name('exec.dashboard');
        Route::get('/reception-log', 'HomeController@receptionLog')->name('exec.reception.log');
        Route::get('/reception-log/arrived', 'HomeController@receptionLogArrived')->name('exec.reception.log.arrived');
        Route::get('/reception-log/cancelled', 'HomeController@receptionLogCancelled')->name('exec.reception.log.cancelled');
        Route::post('/reception-log/update-notes/{id}', 'HomeController@updateNotes')->name('exec.update.notes');
        Route::get('/admin-contacts', 'HomeController@contacts')->name('exec.contacts');

        //Route Appointments
        Route::get('/appointments', 'AppointmentController@index')->name('exec.appointment.index');
        //Route::get('/appointments/customer-search', 'AppointmentController@customerSearch')->name('exec.customer.search');

        Route::get('/appointments/get-dates', 'AppointmentController@dates')->name('exec.dates');

        Route::get('/appointments/event', 'AppointmentController@event')->name('exec.event');
        Route::get('/appointments/get-time-slots', 'AppointmentController@slots')->name('exec.slots');
        Route::post('/appointments/store-appointment', 'AppointmentController@storeAppointment')->name('exec.store.appointment');
        Route::post('/appointments/not-interested', 'AppointmentController@notInterested')->name('exec.store.not.interested');
        Route::post('/appointments/in-progress', 'AppointmentController@inProgress')->name('exec.store.in.progress');
        Route::post('/appointments/cancelled', 'AppointmentController@cancelled')->name('exec.store.cancelled');
        Route::post('/appointments/save-notes', 'AppointmentController@saveNotes')->name('exec.save.notes');

        Route::post('/appointments/update-appointment', 'AppointmentController@updateAppointment')->name('exec.update.appointment');
        Route::get('/appointments/delete-appointment', 'AppointmentController@deleteAppointment')->name('exec.delete.appointment');
        Route::get('/appointments/confirm-appointment', 'AppointmentController@deleteAppointment')->name('exec.confirm.appointment');
        Route::get('/appointments/log/{exec_id}/{date_id}', 'AppointmentController@logAppointment')->name('exec.log.appointment');

        //Route::post('/appointments/fetch-customers', 'AppointmentController@fetchCustomers')->name('exec.fetch.customers');

        //Route Prospects
        Route::get('/prospects', 'ProspectController@index')->name('exec.prospect.index');

        Route::get('/prospects/register/{event_id}/{dealership_id}', 'ProspectController@prospectsRegister')->name('exec.prospect.register');
        Route::post('/prospects/store', 'ProspectController@store')->name('exec.prospect.store');
        Route::get('/prospect/get-times', 'ProspectController@getTimes')->name('exec.get.times');
        Route::get('/prospect/get-execs', 'ProspectController@getExecs')->name('exec.get.execs');

        Route::get('/prospects/create-appointment', 'ProspectController@createAppointment')->name('exec.create.prospect.appointment');
        Route::get('/prospects/show/{id}', 'ProspectController@show')->name('exec.prospect.show');
        Route::post('/prospects/update/{id}', 'ProspectController@update')->name('exec.prospect.update');
        Route::get('/prospects/create-sale', 'ProspectController@createSale')->name('exec.create.sale');
        Route::get('/prospects/show-sale', 'ProspectController@showSale')->name('exec.show.sale');
        Route::get('/prospects/show-date-time', 'ProspectController@showDateTime')->name('exec.show.date.time');
        Route::post('/prospects/update-date-time', 'ProspectController@updateDateTime')->name('exec.update.date.time');

        Route::get('/prospects/log/{id}', 'ProspectController@log')->name('exec.prospect.log');
        Route::post('/prospects/update-log/{id}', 'ProspectController@updateLog')->name('exec.prospect.update.log');

        Route::get('/prospects/create-appointment/{event_id}/{dealership_id}/{prospect_id}', 'ProspectController@createAppointment')->name('exec.create.appointment');
        Route::get('/prospects/edit-appointment/{event_id}/{dealership_id}/{prospect_id}', 'ProspectController@editAppointment')->name('exec.edit.appointment');
        // Route::post('/prospects/update-appointment', 'ProspectController@updateAppointment')->name('exec.update.prospect.appointment');

        Route::get('/prospects/fetchData', 'ProspectController@fetchData');
        Route::get('/prospects/fetchConfirmedData', 'ProspectController@fetchConfirmedData');
        Route::get('/prospects/fetchInProgressData', 'ProspectController@fetchInProgressData');
        Route::get('/prospects/fetchCompletedData', 'ProspectController@fetchCompletedData');
        Route::get('/prospects/fetchHotProspectdData', 'ProspectController@fetchHotProspectdData');
        Route::get('/prospects/get-times', 'ProspectController@getTimes')->name('exec.get.times');

        //Route Sales
        Route::get('/sales', 'SaleController@index')->name('exec.sale.index');
        Route::get('/sales/create/{book_id}', 'SaleController@create')->name('exec.sale.create');
        Route::post('/sales/store', 'SaleController@store')->name('exec.sale.store');
        Route::get('/sales/edit/{id}', 'SaleController@edit')->name('exec.sale.edit');
        Route::post('/sales/update/{id}', 'SaleController@update')->name('exec.sale.update');
        Route::get('/sales/show/{id}', 'SaleController@show')->name('exec.sale.show');
        Route::get('/sales/delete', 'SaleController@delete')->name('exec.sale.delete');

        //Route Sales League
        Route::get('/sales-league', 'SaleLeagueController@index')->name('exec.sale.league.index');
        Route::post('/sales-league/store', 'SaleLeagueController@store')->name('exec.sale.league.store');
        Route::post('/sales-league/update', 'SaleLeagueController@update')->name('exec.sale.league.update');
        Route::get('/sales-league/log-sale', 'SaleLeagueController@logSale')->name('exec.log.sale');
        Route::get('/sales-league/show/{id}', 'SaleLeagueController@show')->name('exec.sale.league.show');
        Route::get('/sales-league/delete', 'SaleLeagueController@delete')->name('exec.sale.league.delete');

        // Login
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('exec.login');
        Route::post('login', 'Auth\LoginController@login');
        Route::get('audi', 'Auth\LoginController@showAudiEventForm')->name('exec.audi');
        Route::get('audi/login', 'Auth\LoginController@showAudiEventForm')->name('exec.audi.login');
        Route::get('volkswagen', 'Auth\LoginController@showVolkswagenEventForm')->name('exec.volkswagen');
        Route::get('volkswagen/login', 'Auth\LoginController@showVolkswagenEventForm')->name('exec.volkswagen.login');
        Route::get('oldham-volkswagen', 'Auth\LoginController@showOldhamVolkswagenEventForm')->name('exec.oldham.volkswagen');
        Route::get('oldham-volkswagen/login', 'Auth\LoginController@showOldhamVolkswagenEventForm')->name('exec.oldham.volkswagen.login');
        Route::get('honda', 'Auth\LoginController@showHondaEventForm')->name('exec.honda');
        Route::get('landrover', 'Auth\LoginController@showLandRoverEventForm')->name('exec.landrover');
        Route::get('peugeot', 'Auth\LoginController@showPeugeotEventForm')->name('exec.peugeot');
        Route::get('seat', 'Auth\LoginController@showSeatEventForm')->name('exec.seat');
        Route::get('cupra', 'Auth\LoginController@showCupraEventForm')->name('exec.cupra');


        Route::post('logout', 'Auth\LoginController@logout')->name('exec.logout');

        // Register
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('exec.register');
        Route::post('register', 'Auth\RegisterController@register');

        // Passwords
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('exec.password.email');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('exec.password.request');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('exec.password.reset');

        // Must verify email
        Route::get('email/resend','Auth\VerificationController@resend')->name('exec.verification.resend');
        Route::get('email/verify','Auth\VerificationController@show')->name('exec.verification.notice');
        Route::get('email/verify/{id}/{hash}','Auth\VerificationController@verify')->name('exec.verification.verify');

        Route::get('account', 'AccountController@account')->name('exec.account');
        Route::patch('account/update', 'AccountController@update')->name('exec.account.update');


    //Password expired
    Route::GET('/password/expired', 'Auth\ExecExpiredPasswordController@expired')->name('exec.password.expired');
    Route::POST('/password/updated', 'Auth\ExecExpiredPasswordController@passwordUpdated')->name('exec.password.updated');


});
