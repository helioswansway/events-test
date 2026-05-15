<?php

Route::group(['namespace' => 'Book'], function() {
    Route::get('/', 'HomeController@index')->name('book.dashboard');
    Route::get('/appointment', 'HomeController@appointment')->name('book.appointment');
    Route::post('/part-exchange', 'HomeController@savePartExchange')->name('book.save.part.exchange');
    Route::get('/part-exchange', 'HomeController@partExchange')->name('book.part.exchange');
    // Route::get('/confirm-details', 'HomeController@confirmDetails')->name('book.confirm-details');
    Route::get('/booking-confirmation', 'HomeController@bookingConfirmation')->name('book.confirmation');
    Route::post('/submit-booking', 'HomeController@submitBooking')->name('book.submit.booking');
    Route::post('/resend-email', 'HomeController@resendEmail')->name('book.resend.email');
    Route::get('/test-email', 'HomeController@testEmail');
    Route::get('/booked', 'HomeController@booked')->name('book.booked');

    Route::post('/appointment/save-model', 'AppointmentController@saveModel')->name('book.save.model');

    Route::post('/appointment/store-no-exec', 'AppointmentController@storeNoExec')->name('book.appointment.store.no.exec');
    Route::post('/appointment/store', 'AppointmentController@store')->name('book.appointment.store');
    Route::get('/appointments/get-times', 'AppointmentController@getTimes')->name('book.get.times');
    Route::get('/appointments/get-execs', 'AppointmentController@getExecs')->name('book.get.execs');
    //Route::post('/update-time', 'AppointmentController@updateTime')->name('book.update.time');
    //Route::post('/update-exec', 'AppointmentController@updateExec')->name('book.update.exec');
    //Route::post('/get-execs', 'AppointmentController@getExecs')->name('book.get.exec');
    //Route::post('/booked-exec', 'AppointmentController@bookedExec')->name('book.booked.exec');

    //Updates Customer Part Exchange Details/Information
    Route::post('/part-exchange-details', 'AppointmentController@partExchangeDetails')->name('book.part.exchange.details');
    Route::post('/no-part-exchange-details', 'AppointmentController@noPartExchangeDetails')->name('book.no.part.exchange.details');

    //Returns Customer Vehicle details from the DVLA API
    Route::get('/show-vehicle-details', 'DvlaController@showVehicleDetails')->name('book.show.vehicle.details');

    //Updates Customer Personal Details
    Route::post('/save-personal-details', 'AppointmentController@savePersonalDetails')->name('book.save.personal.details');
    //Updates Customer Address Details
    Route::post('/save-address-details', 'AppointmentController@saveAddressDetails')->name('book.save.address.details');

    // Reset unique code
    Route::get('reset-unique-code', 'Auth\LoginController@resetForm')->name('book.reset.code.form');
    Route::post('reset-code', 'Auth\LoginController@resetUniqueCode')->name('book.reset.code');

    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('book.login');
    Route::get('audi', 'Auth\LoginController@showAudiEventForm')->name('book.audi');
    Route::get('audi/login', 'Auth\LoginController@showAudiEventForm')->name('book.audi.login');

    Route::get('blackburn-audi', 'Auth\LoginController@showBlackburnAudiEventForm')->name('book.blackburn.audi.login');
    Route::get('blackburn-audi/login', 'Auth\LoginController@showBlackburnAudiEventForm')->name('book.blackburn.audi.login');

    Route::get('carlisle-audi', 'Auth\LoginController@showCarlisleAudiEventForm')->name('book.carlisle.audi');
    Route::get('carlisle-audi/login', 'Auth\LoginController@showCarlisleAudiEventForm')->name('book.carlisle.audi.login');
    Route::get('preston-audi', 'Auth\LoginController@showPrestonAudiEventForm')->name('book.preston.audi');
    Route::get('preston-audi/login', 'Auth\LoginController@showPrestonAudiEventForm')->name('book.preston.audi.login');
    Route::get('crewe-audi', 'Auth\LoginController@showCreweAudiEventForm')->name('book.crewe.audi');
    Route::get('crewe-audi/login', 'Auth\LoginController@showCreweAudiEventForm')->name('book.crewe.audi.login');
    Route::get('stafford-audi', 'Auth\LoginController@showStaffordAudiEventForm')->name('book.stafford.audi');
    Route::get('stafford-audi/login', 'Auth\LoginController@showStaffordAudiEventForm')->name('book.stafford.audi');
    Route::get('stoke-audi', 'Auth\LoginController@showStokeAudiEventForm')->name('book.stoke.audi');
    Route::get('stoke-audi/login', 'Auth\LoginController@showStokeAudiEventForm')->name('book.stoke.audi.login');


    Route::get('volkswagen', 'Auth\LoginController@showVolkswagenEventForm')->name('book.volkswagen');
    Route::get('volkswagen/login', 'Auth\LoginController@showVolkswagenEventForm')->name('book.volkswagen.login');
    Route::get('oldham-volkswagen', 'Auth\LoginController@showOldhamVolkswagenEventForm')->name('book.oldham.volkswagen');
    Route::get('oldham-volkswagen/login', 'Auth\LoginController@showOldhamVolkswagenEventForm')->name('book.oldham.volkswagen.login');
    Route::get('crewe-volkswagen', 'Auth\LoginController@showCreweVolkswagenEventForm')->name('book.crewe.volkswagen');
    Route::get('crewe-volkswagen/login', 'Auth\LoginController@showCreweVolkswagenEventForm')->name('book.crewe.volkswagen.login');
    Route::get('wrexham-volkswagen', 'Auth\LoginController@showWrexhamVolkswagenEventForm')->name('book.wrexham.volkswagen');
    Route::get('wrexham-volkswagen/login', 'Auth\LoginController@showWrexhamVolkswagenEventForm')->name('book.wrexham.volkswagen.login');


    //Volkswagen Commercials logins
    Route::get('volkswagen-van-centre', 'Auth\LoginController@showVolkswagenCommercialsEventForm')->name('book.volkswagen.commercials');
    Route::get('volkswagen-van-centre/login', 'Auth\LoginController@showVolkswagenCommercialsEventForm')->name('book.volkswagen.commercials.login');

    Route::get('volkswagen-van-centre-birmingham', 'Auth\LoginController@showVolkswagenCommercialBirminghamEventForm')->name('book.volkswagen.commercial.birmingham');
    Route::get('volkswagen-van-centre-birmingham/login', 'Auth\LoginController@showVolkswagenCommercialBirminghamEventForm')->name('book.volkswagen.commercial.birmingham');

    Route::get('volkswagen-van-centre-lancashire', 'Auth\LoginController@showVolkswagenCommercialLancashireEventForm')->name('book.volkswagen.commercial.lancashire');
    Route::get('volkswagen-van-centre-lancashire/login', 'Auth\LoginController@showVolkswagenCommercialLancashireEventForm')->name('book.volkswagen.commercial.lancashire');

    Route::get('volkswagen-van-centre-liverpool', 'Auth\LoginController@showVolkswagenCommercialLiverpoolEventForm')->name('book.volkswagen.commercial.liverpool');
    Route::get('volkswagen-van-centre-liverpool/login', 'Auth\LoginController@showVolkswagenCommercialLiverpoolEventForm')->name('book.volkswagen.commercial.liverpool');

    Route::get('volkswagen-van-centre-oldham', 'Auth\LoginController@showVolkswagenCommercialOldhamEventForm')->name('book.volkswagen.commercial.oldham');
    Route::get('volkswagen-van-centre-oldham/login', 'Auth\LoginController@showVolkswagenCommercialOldhamEventForm')->name('book.volkswagen.commercial.oldham');

    Route::get('volkswagen-van-centre-wrexham', 'Auth\LoginController@showVolkswagenCommercialWrexhamEventForm')->name('book.volkswagen.commercial.wrexham');
    Route::get('volkswagen-van-centre-wrexham/login', 'Auth\LoginController@showVolkswagenCommercialWrexhamEventForm')->name('book.volkswagen.commercial.wrexham');


    Route::get('honda/login', 'Auth\LoginController@showHondaEventForm')->name('book.honda.login');
    Route::get('honda', 'Auth\LoginController@showHondaEventForm')->name('book.honda');

    Route::get('landrover/login', 'Auth\LoginController@showLandRoverEventForm')->name('book.landrover.login');
    Route::get('landrover', 'Auth\LoginController@showLandRoverEventForm')->name('book.landrover');

    Route::get('landrover/defender', 'Auth\LoginController@showLandRoverDefenderLoginForm')->name('book.landrover.defender.login');
    Route::get('landrover/discovery', 'Auth\LoginController@showLandRoverDiscoveryLoginForm')->name('book.landrover.discovery.login');
    Route::get('landrover/rangerover', 'Auth\LoginController@showLandRoverRangeRoverLoginForm')->name('book.landrover.rangerover.login');


    Route::get('peugeot/login', 'Auth\LoginController@showPeugeotEventForm')->name('book.peugeot.login');
    Route::get('peugeot', 'Auth\LoginController@showPeugeotEventForm')->name('book.peugeot');

    Route::get('seat/login', 'Auth\LoginController@showSeatEventForm')->name('book.seat.login');
    Route::get('seat', 'Auth\LoginController@showSeatEventForm')->name('book.seat');

    Route::get('cupra/login', 'Auth\LoginController@showCupraEventForm')->name('book.cupra.login');
    Route::get('cupra', 'Auth\LoginController@showCupraEventForm')->name('book.cupra');

    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('book.logout');

    // Register forms
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('book.register');
    Route::get('register-audi', 'Auth\RegisterController@showAudiRegistrationForm')->name('book.register.audi');
    Route::get('register-volkswagen', 'Auth\RegisterController@showVolkswagenRegistrationForm')->name('book.register.volkswagen');
    Route::get('register-volkswagen-van-centre', 'Auth\RegisterController@showVolkswagenCommercialsRegistrationForm')->name('book.register.volkswagen.commercials');
    Route::get('register-oldham-volkswagen', 'Auth\RegisterController@showOldhamVolkswagenRegistrationForm')->name('book.register.oldham.volkswagen');
    Route::get('register-honda', 'Auth\RegisterController@showHondaRegistrationForm')->name('book.register.honda');

    Route::get('register-landrover', 'Auth\RegisterController@showLandRoverRegistrationForm')->name('book.register.landrover');
    Route::get('register/landrover/defender', 'Auth\RegisterController@showDefenderRegistrationForm')->name('book.register.defender');
    Route::get('register/landrover/discovery', 'Auth\RegisterController@showDiscoveryRegistrationForm')->name('book.register.discovery');
    Route::get('register/landrover/rangerover', 'Auth\RegisterController@showRangeRoverRegistrationForm')->name('book.register.rangerover');

    Route::get('register-peugeot', 'Auth\RegisterController@showPeugeotRegistrationForm')->name('book.register.peugeot');
    Route::get('register-seat', 'Auth\RegisterController@showSeatRegistrationForm')->name('book.register.seat');
    Route::get('register-cupra', 'Auth\RegisterController@showCupraRegistrationForm')->name('book.register.cupra');

    Route::post('register', 'Auth\RegisterController@register');
    Route::post('register/customer', 'Auth\RegisterController@registerCustomer')->name('book.register.customer');
    Route::get('/register/fetchEvents', 'Auth\RegisterController@fetchEvents');
    Route::get('registration-code/{id}', 'Auth\RegisterController@registerCustomerCode')->name('book.register.customerCode');

    // Passwords
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('book.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('book.password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('book.password.reset');

    // Must verify email
    Route::get('email/resend','Auth\VerificationController@resend')->name('book.verification.resend');
    Route::get('email/verify','Auth\VerificationController@show')->name('book.verification.notice');
    Route::get('email/verify/{id}/{hash}','Auth\VerificationController@verify')->name('book.verification.verify');
});
