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


##########################################################################################
##########################################################################################
//Dashboard
##########################################################################################
##########################################################################################
Route::group([
    'prefix'     => 'dashboard',
    'middleware' => 'auth:admin',
], function () {

    Route::middleware(['admin_password_expired'])->group(function () {

        Route::middleware(['role:super'])->group(function () {
            Route::get('/migrate', 'Admin\DashboardController@migrate')->name('dashboard.migrate');
            Route::get('/queue-work', 'Admin\DashboardController@queueWork')->name('dashboard.queue.work');
            Route::get('/db-dump', 'Admin\DashboardController@dbDump')->name('dashboard.db-dump');
            Route::get('/files-dump', 'Admin\DashboardController@filesDump')->name('dashboard.files-dump');
            Route::get('/backup-all', 'Admin\DashboardController@backupAll')->name('dashboard.backup-all');
        });

        Route::get('/', 'Admin\DashboardController@index')->name('admin');

        Route::get('/query', 'Admin\TestController@query');


        //User Account Controller
        ##########################################################################################
        Route::get('/account', 'Admin\AccountController@index')->name('account.index');
        //Route::post('/account', 'Admin\AccountController@store')->name('admin.store');
        //Route::patch('/{id}', 'Admin\AccountController@update')->name('account.update');
        Route::patch('/update-account/{admin}', 'Admin\AccountController@updateAccount')->name('admin.update-account');
        Route::get('/resends-password/{id}', 'Admin\AccountController@resendsPassword')->name('admin.resends.password');

        //Brands Controller
        ##########################################################################################
        Route::get('/brands', 'Admin\BrandController@index')->name('brand.index');
        Route::get('/brands/create', 'Admin\BrandController@create')->name('brand.create')->middleware('role:super-admin;admin');
        Route::post('/brands/store', 'Admin\BrandController@store')->name('brand.store')->middleware('role:super-admin;admin');
        Route::get('/brands/edit/{id}', 'Admin\BrandController@edit')->name('brand.edit')->middleware('role:super-admin;admin');
        Route::post('/brands/update/{id}', 'Admin\BrandController@update')->name('brand.update')->middleware('role:super-admin;admin');
        Route::get('/brands/delete/{id}', 'Admin\BrandController@delete')->name('brand.delete')->middleware('role:super-admin;admin');


        //Dealerships Controller
        ##########################################################################################
        Route::get('/dealerships', 'Admin\DealershipController@index')->name('dealership.index')->middleware('role:super-admin;admin');
        Route::get('/dealerships/create', 'Admin\DealershipController@create')->name('dealership.create')->middleware('role:super-admin;admin');
        Route::post('/dealerships/store', 'Admin\DealershipController@store')->name('dealership.store')->middleware('role:super-admin;admin');
        Route::get('/dealerships/edit/{id}', 'Admin\DealershipController@edit')->name('dealership.edit')->middleware('role:super-admin;admin');
        Route::post('/dealerships/update/{id}', 'Admin\DealershipController@update')->name('dealership.update')->middleware('role:super-admin;admin');
        Route::get('/dealerships/delete/{id}', 'Admin\DealershipController@delete')->name('dealership.delete')->middleware('role:super-admin;admin');


        //Super Admin Access
        ##########################################################################################
        Route::middleware(['role:super-admin'])->group(function () {

            //Admins Registration Controller
            ##########################################################################################
            Route::patch('/register/{admin}', 'Admin\RegisterController@update')->name('admin.registration.update');

            Route::get('/admins', 'Admin\AdminController@index')->name('admin.index');
            Route::get('/admins/create', 'Admin\AdminController@create')->name('admin.create');
            Route::post('/admins/store', 'Admin\AdminController@store')->name('admin.store');
            Route::get('/admins/edit/{id}', 'Admin\AdminController@edit')->name('admin.edit');
            Route::patch('/admins/update/{id}', 'Admin\AdminController@update')->name('admin.update');
            Route::get('/admins/fetchData', 'Admin\AdminController@fetchData')->name('admin.fetch.data');
            Route::get('/admins/export', 'Admin\AdminController@export')->name('admin.export');
            Route::get('/admins/delete/{id}', 'Admin\AdminController@delete')->name('admin.delete');

            //Events Controller
            ##########################################################################################
            Route::get('/events', 'Admin\EventController@index')->name('event.index');

            Route::get('/events/manage', 'Admin\EventController@manage')->name('event.manage');

            Route::get('/events/create', 'Admin\EventController@create')->name('event.create');
            Route::get('/events/configure/{id}', 'Admin\EventController@createConfiguration')->name('event.create.configuration');
            Route::get('/events/configure/event/{event_id}/dealership/{dealer_id}', 'Admin\EventController@deleteEventDealership')->name('event.delete.dealership');

            Route::get('/events/edit/{id}', 'Admin\EventController@edit')->name('event.edit');
            Route::post('/events/update/{id}', 'Admin\EventController@update')->name('event.update');


            Route::get('/events/delete/{id}', 'Admin\EventController@delete')->name('event.delete');
            Route::post('/events/store', 'Admin\EventController@store');

            //Events Configuration Controller
            ##########################################################################################
            Route::get('/events/configure/{id}', 'Admin\EventConfigurationController@configure')->name('event.configure');
            Route::get('/events/configure/{event_id}/{dealership_id}/dates', 'Admin\EventConfigurationController@configureDates')->name('event.configure.dates');
            Route::get('/events/configure/{event_id}/{dealership_id}/{date_id}/times', 'Admin\EventConfigurationController@configureTimes')->name('event.configure.times');
            Route::get('/events/configure/{id}/execs', 'Admin\EventConfigurationController@configureExecs')->name('event.configure.execs');

            Route::get('/events/show-dates', 'Admin\EventConfigurationController@showDates')->name('event.show.dates');
            Route::get('/events/add-date', 'Admin\EventConfigurationController@addDate')->name('event.add.date');
            Route::get('/events/plus-date', 'Admin\EventConfigurationController@plusDate')->name('event.plus.date');
            Route::get('/events/minus-date', 'Admin\EventConfigurationController@minusDate')->name('event.minus.date');
            Route::get('/events/add-time', 'Admin\EventConfigurationController@addTime')->name('event.add.time');
            Route::post('/events/fetch-exec', 'Admin\EventConfigurationController@fetchExec')->name('event.fetch.exec');
            Route::post('/events/add-exec-to-time-slot', 'Admin\EventConfigurationController@addExecToTimeSlot')->name('event.add.exec.to.time.slot');
            Route::get('/events/delete-exec-from-time-slot/{exec_id}', 'Admin\EventConfigurationController@deleteExecFromTimeSlot')->name('event.delete.exec.from.time.slot');
            Route::get('/events/delete-exec-from-event/{exec_id}', 'Admin\EventConfigurationController@deleteExecFromEvent')->name('event.delete.exec.from.event');
            Route::get('/events/delete-date', 'Admin\EventConfigurationController@deleteDate')->name('event.delete.date');
            Route::get('/events/reset-time-slots', 'Admin\EventConfigurationController@resetTimeSlots')->name('event.reset.time.slots');
            Route::get('/events/split-customers-to-execs', 'Admin\EventConfigurationController@splitCustomers')->name('event.split.customers');


            //Archive Appointments
            ##########################################################################################
            Route::get('/archive/events', 'Admin\ArchiveAppointmentController@index')->name('archive.index');
            Route::get('/archive/show/{id}', 'Admin\ArchiveAppointmentController@show')->name('archive.show');
            Route::get('/archive/delete/{id}', 'Admin\ArchiveAppointmentController@delete')->name('archive.delete');


            //Vehicles Controller
            ##########################################################################################
            Route::get('/vehicles', 'Admin\VehicleController@index')->name('vehicle.index');
            Route::get('/vehicles/create', 'Admin\VehicleController@create')->name('vehicle.create');
            Route::get('/vehicles/edit/{id}', 'Admin\VehicleController@edit')->name('vehicle.edit');
            Route::get('/vehicles/edit-by-brand/{id}', 'Admin\VehicleController@editByBrand')->name('vehicle.edit.by.brand');
            Route::post('/vehicles/update/{id}', 'Admin\VehicleController@update')->name('vehicle.update');
            Route::get('/vehicles/delete/{id}', 'Admin\VehicleController@delete')->name('vehicle.delete');
            Route::post('/vehicles/store', 'Admin\VehicleController@store');
            Route::post('/vehiclePosition', 'Admin\VehicleController@vehiclePosition')->name('vehicle.position');

        });


        Route::middleware(['role:super-admin;brand-manager'])->group(function () {

            //Execs Controller
            ##########################################################################################
            Route::get('/execs', 'Admin\ExecController@index')->name('exec.index');

            Route::get('/execs/search', 'Admin\ExecController@search')->name('exec.search');

            Route::get('/execs/fetchData', 'Admin\ExecController@fetchData');

            Route::get('/execs/upload', 'Admin\ExecController@upload')->name('exec.upload');
            Route::post('/execs/store', 'Admin\ExecController@store')->name('exec.store');
            Route::get('/execs/create', 'Admin\ExecController@create')->name('exec.create');
            Route::post('/execs/store-exec', 'Admin\ExecController@storeExec')->name('exec.store.exec');
            Route::get('/execs/received', 'Admin\ExecController@received')->name('exec.received');
            Route::get('/execs/show/{id}', 'Admin\ExecController@show')->name('exec.show');
            Route::get('/execs/edit/{id}', 'Admin\ExecController@edit')->name('exec.edit');
            Route::get('/execs/all-appointments/{exec_id}', 'Admin\ExecController@execAppointments')->name('exec.all.appointments');
            Route::get('/execs/prospects/{exec_id}', 'Admin\ExecController@execProspects')->name('exec.all.prospects');
            Route::get('/execs/fetchProspectsData', 'Admin\ExecController@fetchProspectsData');

            Route::post('/execs/update/{id}', 'Admin\ExecController@update')->name('exec.update');
            Route::get('/execs/delete/{id}', 'Admin\ExecController@delete')->name('exec.delete');
            Route::get('/execs/export', 'Admin\ExecController@export')->name('exec.export');



        });

        Route::middleware(['role:super-admin'])->group(function () {
            Route::get('/execs/prospects-export/{exec_id}', 'Admin\ExecController@prospectExport')->name('exec.prospect.export');
        });

        Route::middleware(['role:super-admin;appointments'])->group(function () {
            Route::get('/execs/by-dealership/{dealership_id}', 'Admin\ExecController@execDealershipExport')->name('exec.dealership.export');
        });

        Route::middleware(['role:super-admin'])->group(function () {
            Route::get('/execs/prospects-remove/{exec_id}', 'Admin\ExecController@prospectRemove')->name('exec.prospect.remove');
        });


        Route::middleware(['role:super-admin;renewals;brand-manager'])->group(function () {
            //Customer Controller
            ##########################################################################################
            Route::get('/customers', 'Admin\CustomerController@index')->name('customer.index');

            Route::get('/customers/search', 'Admin\CustomerController@search')->name('customer.search');
            Route::get('/customers/fetchData', 'Admin\CustomerController@fetchData');
            Route::get('/customers/fetchEvents', 'Admin\CustomerController@fetchEvents');

            Route::get('/customers/register', 'Admin\CustomerController@register')->name('customer.register');
            Route::post('/customers/register', 'Admin\CustomerController@registerCustomer')->name('customer.register.customer');
            Route::get('/customers/create', 'Admin\CustomerController@create')->name('customer.create');
            Route::post('/customer/store', 'Admin\CustomerController@store')->name('customer.store');
            Route::get('/customer/received', 'Admin\CustomerController@received')->name('customer.received');
            Route::get('/customers/show/{id}', 'Admin\CustomerController@show')->name('customer.show');
            Route::get('/customers/edit/{id}', 'Admin\CustomerController@edit')->name('customer.edit');
            Route::get('/customers/delete/{id}', 'Admin\CustomerController@delete')->name('customer.delete');

            //Route::get('/customers/assign-to-execs/{id}', 'Admin\CustomerController@assignToExec')->name('customer.assign.to.exec');

            Route::post('/customers/update/{id}', 'Admin\CustomerController@update')->name('customer.update');
            Route::post('/customers/update-prospect', 'Admin\CustomerController@updateProspect')->name('customer.update.prospect');
            Route::get('/customers/edit-dealership', 'Admin\CustomerController@editDealership')->name('customer.edit.dealership');
            Route::get('/customers/get-execs', 'Admin\CustomerController@getExecs')->name('customer.get.execs');
            Route::post('/customers/exec/update/{id}', 'Admin\CustomerController@execUpdate')->name('customer.exec.update');

            Route::get('/customers/get-dealerships', 'Admin\CustomerController@getDealerships')->name('customer.get.dealerships');



        });

        Route::middleware(['role:super-admin;appointments;renewals;reception;brand-manager'])->group(function () {
            //Appointments Controller
            ##########################################################################################
            Route::get('/appointments', 'Admin\AppointmentController@index')->name('admin.appointment.index');
            Route::get('/appointments/show/{id}', 'Admin\AppointmentController@show')->name('admin.appointment.show');

            Route::get('/appointments/logs/{date_id}/{id}', 'Admin\AppointmentController@logAppointment')->name('admin.log.appointment');
            Route::get('/appointments/delete/{id}', 'Admin\AppointmentController@deleteAppointment')->name('admin.delete.appointment');
            Route::get('/appointments/reception/{id}', 'Admin\AppointmentController@receptionLog')->name('admin.appointment.reception');
            Route::get('/appointments/reception-log/arrived', 'Admin\AppointmentController@receptionLogArrived')->name('admin.appointment.reception.arrived');
            Route::get('/appointments/reception-log/no-show', 'Admin\AppointmentController@receptionNoShow')->name('admin.appointment.reception.no.show');
            Route::get('/appointments/reception-log/cancelled', 'Admin\AppointmentController@receptionLogCancelled')->name('admin.appointment.reception.cancelled');
            Route::post('/appointments/update-notes/{id}', 'Admin\AppointmentController@updateNotes')->name('appointment.update.notes');

            Route::get('/appointments/create-appointment/{event_id}/{dealership_id}/{prospect_id}', 'Admin\AppointmentController@adminCreateAppointment')->name('admin.create.appointment');
            Route::post('/appointment/store', 'Admin\AppointmentController@storesAppointment')->name('admin.appointment.store');
            Route::get('/appointments/edit-appointment/{event_id}/{dealership_id}/{prospect_id}', 'Admin\AppointmentController@adminEditAppointment')->name('admin.edit.appointment');

            Route::get('/appointments/prospects/{event_id}/{dealership_id}', 'Admin\AppointmentController@prospects')->name('admin.appointment.prospect');
            Route::get('/appointments/prospects/registered/{event_id}/{dealership_id}', 'Admin\AppointmentController@prospectsRegistered')->name('admin.appointment.prospect.registered');
            Route::get('/appointments/prospects/register/{event_id}/{dealership_id}', 'Admin\AppointmentController@appointmentProspectsRegister')->name('admin.appointment.prospect.register');
            Route::post('/appointment/store-prospect', 'Admin\AppointmentController@storesProspectAndAppointment')->name('admin.appointment.store.prospect');

            Route::get('/prospects/fetchData', 'Admin\AppointmentController@fetchData');
            Route::get('/prospects/fetchConfirmedData', 'Admin\AppointmentController@fetchConfirmedData');
            Route::get('/prospects/fetchInProgressData', 'Admin\AppointmentController@fetchInProgressData');
            Route::get('/prospects/fetchHotProspectData', 'Admin\AppointmentController@fetchHotProspectData');
            Route::get('/prospects/fetchCompletedData', 'Admin\AppointmentController@fetchCompletedData');
            Route::get('/prospects/fetchRequireCallBack', 'Admin\AppointmentController@fetchRequireCallBack');
            Route::get('/prospects/fetchSaleData', 'Admin\AppointmentController@fetchSaleData');

            Route::get('/appointment/prospects/hot-leads/{event_id}/{dealership_id}', 'Admin\AppointmentController@hotLeads')->name('admin.appointment.hot.leads');
            Route::get('/appointment/prospects/show-in-progress/{event_id}/{dealership_id}', 'Admin\AppointmentController@showInProgress')->name('admin.appointment.show.in.progress');
            Route::get('/appointment/prospects/sales/{event_id}/{dealership_id}', 'Admin\AppointmentController@showSales')->name('admin.appointment.show.sales');

            Route::get('/appointments/get-times', 'Admin\AppointmentController@getTimes')->name('admin.get.times');
            Route::get('/appointments/get-edit-times', 'Admin\AppointmentController@getEditTimes')->name('admin.get.edit.times');
            Route::get('/appointments/get-execs', 'Admin\AppointmentController@getExecs')->name('admin.get.execs');
            Route::get('/appointments/get-edit-execs', 'Admin\AppointmentController@getEditExecs')->name('admin.get.edit.execs');
            Route::post('/appointment/update', 'Admin\AppointmentController@updateAppointment')->name('admin.appointment.update');

            //Route::post('/appointment/not-interested', 'Admin\AppointmentController@notInterested')->name('admin.store.not.interested');
            //Route::post('/appointment/cancelled', 'Admin\AppointmentController@cancelled')->name('admin.store.cancelled');
            //Route::post('/appointment/in-progress', 'Admin\AppointmentController@inProgress')->name('admin.store.in-progress');

            Route::get('/appointment/sales/create/{appointment_id}', 'Admin\AppointmentController@createSale')->name('admin.exec.sale.create');
            Route::post('/appointment/sales/store', 'Admin\AppointmentController@storeSale')->name('admin.exec.sale.store');

            //Exports
            Route::get('/export/appointments/{event_id}', 'Admin\ExportController@exportAppointment')->name('admin.appointment.export.all');
            Route::get('/export/sales/{event_id}', 'Admin\ExportController@exportSales')->name('admin.sale.export.all');
            Route::get('/export/prospects/{event_id}', 'Admin\ExportController@exportProspects')->name('admin.prospects.export.all');
            Route::get('/export/prospects/appointments/{event_id}', 'Admin\ExportController@exportProspectAppointments')->name('admin.prospects.export.appointments');
            Route::get('/export/convertions-appointments/{event_id}', 'Admin\ExportController@exportConversions')->name('admin.conversions.export.all');

            Route::get('/export/archived-appointments/{archive_id}', 'Admin\ExportController@exportArchivedAppointments')->name('admin.archived.appointments.export.all');

        });


        Route::middleware(['role:super-admin;brand-manager;appointments;renewals'])->group(function () {
            //Route Sales
            Route::get('/sales/edit/{id}', 'Admin\SaleController@edit')->name('admin.sale.edit');
            Route::get('/sales/create/{book_id}', 'Admin\SaleController@create')->name('admin.sale.create');
            Route::post('/sales/store', 'Admin\SaleController@store')->name('admin.sale.store');
            Route::post('/sales/update/{id}', 'Admin\SaleController@update')->name('admin.sale.update');
            Route::get('/sales/show/{id}', 'Admin\SaleController@show')->name('admin.sale.show');
            Route::get('/sales/delete', 'Admin\SaleController@delete')->name('admin.sale.delete');
            Route::get('/sales/{event_id}/{dealership_id}', 'Admin\SaleController@index')->name('admin.sale.index');
        });

        //Renewals Access Controllers
        Route::middleware(['role:super-admin;renewals'])->group(function () {
            //Appointments Controller
            ##########################################################################################
            Route::get('/appointments/prospects/renewals/{event_id}/{dealership_id}', 'Admin\AppointmentController@prospectsRenewals')->name('admin.appointment.prospect.renewals');
            Route::get('/prospects/fetchRenewalsData', 'Admin\AppointmentController@fetchRenewalsData');
        });

        //Reports Role Access Controllers
        Route::middleware(['role:super-admin;reports'])->group(function () {
            //Reports Controller
            ##########################################################################################
            Route::get('/reports/{id}', 'Admin\ReportController@index')->name('admin.report.index');
        });

        Route::middleware(['role:super-admin;leaderboard'])->group(function () {
            //Route Sales League
            Route::get('/leaderboard', 'Admin\LeaderboardController@index')->name('admin.leaderboard.index');
            Route::post('/leaderboard/store', 'Admin\LeaderboardController@store')->name('admin.leaderboard.store');
            Route::get('/leaderboard/create', 'Admin\LeaderboardController@create')->name('admin.leaderboard.create');
            Route::post('/leaderboard/store-exec', 'Admin\LeaderboardController@storeExec')->name('admin.leaderboard.store.exec');
            Route::get('/leaderboard/reset', 'Admin\LeaderboardController@reset')->name('admin.leaderboard.reset');

            Route::get('/leaderboard/export/{competition_id}', 'Admin\LeaderboardController@export')->name('admin.leaderboard.export');
            Route::get('/export/total', 'Admin\LeaderboardController@exportTotal')->name('admin.leaderboard.export.total');
            Route::get('/export/brand/{competition_id}/{brand_id}', 'Admin\LeaderboardController@exportBrand')->name('admin.leaderboard.export.brand');
            Route::get('/leaderboard/import', 'Admin\LeaderboardController@import')->name('admin.leaderboard.import');

        });


        //Competition Routes
        Route::middleware(['role:super-admin'])->group(function () {
            Route::get('/competition/create', 'Admin\CompetitionController@create')->name('admin.competition.create');
            Route::get('/competition/store', 'Admin\CompetitionController@store')->name('admin.competition.store');
            Route::get('/competition/update', 'Admin\CompetitionController@update')->name('admin.competition.update');
            Route::get('/competition/archive', 'Admin\CompetitionController@archive')->name('admin.competition.archive');
            Route::get('/competition/archived', 'Admin\CompetitionController@archived')->name('admin.competition.archived');
            Route::get('/competition/archived/edit/{id}', 'Admin\CompetitionController@editArchived')->name('admin.competition.edit.archived');
            Route::post('/competition/archived/update/{id}', 'Admin\CompetitionController@updateArchived')->name('admin.competition.update.archived');
            Route::get('/competition/delete', 'Admin\CompetitionController@delete')->name('admin.competition.delete');
        });

        //Competition Image Routes
        Route::middleware(['role:super-admin'])->group(function () {
            Route::get('/competition/create-image/{id}', 'Admin\CompetitionImageController@create')->name('admin.competition.create.image');
            Route::post('/competition/store-image', 'Admin\CompetitionImageController@store')->name('admin.competition.store.image');
            Route::post('/competition/update-image/{id}', 'Admin\CompetitionImageController@update')->name('admin.competition.update.image');
        });

        //Leaderboard based on competition Routes
        Route::middleware(['role:super-admin;leaderboard'])->group(function () {
            Route::get('/competition/show-competition-league', 'Admin\CompetitionController@showCompetitionLeague')->name('admin.competition.show.league');
        });

        //Pot Campaigns Routes
        Route::middleware(['role:super-admin;admin'])->group(function () {
            //Pot Campaign Controllers
            Route::get('/pot-campaign', 'Admin\PotCampaignController@index')->name('admin.pot-campaign.index');
            Route::get('/pot-campaign/create', 'Admin\PotCampaignController@create')->name('admin.pot-campaign.create');
            Route::post('/pot-campaign/store', 'Admin\PotCampaignController@store')->name('admin.pot-campaign.store');
            Route::get('/pot-campaign/edit/{id}', 'Admin\PotCampaignController@edit')->name('admin.pot-campaign.edit');
            Route::post('/pot-campaign/update/{id}', 'Admin\PotCampaignController@update')->name('admin.pot-campaign.update');
            Route::get('/pot-campaign/delete/{id}', 'Admin\PotCampaignController@delete')->name('admin.pot-campaign.delete');
            Route::post('/pot-campaign/itemPosition', 'Admin\PotCampaignController@itemPosition')->name('admin.item.position');

            //Exports Pot Lists based on Campaign
            Route::get('/pot-campaign/export/{competition_id}', 'Admin\PotListController@export')->name('admin.pot-list.export');

        });

        //Pot Campaigns Routes
        Route::middleware(['role:super-admin;pot-list'])->group(function () {
            //Pot List Calls Controllers
            Route::get('/pot-lists', 'Admin\PotListController@index')->name('admin.pot-list.index');
            //Route::get('/pot-campaign/{id}/pot-list', 'Admin\PotListController@potList')->name('admin.pot-list.byCampaign');
            Route::get('/pot-lists/upload', 'Admin\PotListController@upload')->name('admin.pot-list.upload');
            Route::post('/pot-lists/store', 'Admin\PotListController@store')->name('admin.pot-list.store');
            Route::get('/pot-list/show-campaign-list/{id}', 'Admin\PotListController@showCampaignList')->name('admin.pot-list.show');
            Route::post('/pot-list/update/{id}', 'Admin\PotListController@update')->name('admin.pot-list.update');
            Route::get('/pot-list/form/{id}', 'Admin\PotListController@form')->name('admin.pot-list.form');

        });


        Route::middleware(['role:super-admin;admin;pot-list'])->group(function () {
            Route::get('/pot-list/reset/{id}', 'Admin\PotListController@reset')->name('admin.pot-list.reset');

            Route::get('/pot-list/booked/{id}', 'Admin\PotListController@booked')->name('admin.pot-list.booked');
            Route::get('/pot-list/in-progress/{id}', 'Admin\PotListController@inProgress')->name('admin.pot-list.inProgress');
            Route::get('/pot-list/not-interested/{id}', 'Admin\PotListController@notInterest')->name('admin.pot-list.notInterest');

            Route::get('/pot-list/by-dealership/{campaign_id}/{dealership_id}', 'Admin\PotListController@byDealership')->name('admin.pot-list.byDealership');

        });
        //Sale Type and Job Title Routes
        Route::middleware(['role:super-admin'])->group(function () {
            //Sale Type Controllers
            Route::get('/sale-type/create', 'Admin\SaleTypeController@create')->name('admin.sale.type.create');
            Route::get('/sale-type/store', 'Admin\SaleTypeController@store')->name('admin.sale.type.store');
            Route::get('/sale-type/update', 'Admin\SaleTypeController@update')->name('admin.sale.type.update');
            Route::get('/sale-type/delete', 'Admin\SaleTypeController@delete')->name('admin.sale.type.delete');

            //Job Title Controllers
            Route::get('/job-title/create', 'Admin\JobTitleController@create')->name('admin.job.title.create');
            Route::get('/job-title/store', 'Admin\JobTitleController@store')->name('admin.job.title.store');
            Route::get('/job-title/update', 'Admin\JobTitleController@update')->name('admin.job.title.update');
            Route::get('/job-title/delete', 'Admin\JobTitleController@delete')->name('admin.job.title.delete');

        });

        //Leaderboard Routes
        Route::middleware(['role:super-admin'])->group(function () {
            Route::get('/leaderboard/get-execs', 'Admin\LeaderboardController@getExecs')->name('admin.leaderboard.get.execs');
            Route::get('/leaderboard/get-execs-by-competition/{id}', 'Admin\LeaderboardController@getExecsByCompetition')->name('admin.leaderboard.get.execs.by.competition');
            Route::get('/leaderboard/fetchData', 'Admin\LeaderboardController@fetchData');
            //Route::get('/leaderboard/fetchByJobTitle', 'Admin\LeaderboardController@fetchByJobTitle');
            Route::get('/leaderboard/fetchExecsByBrand', 'Admin\LeaderboardController@fetchExecsByBrand');
            Route::get('/leaderboard/fetchExecsByJobTitle', 'Admin\LeaderboardController@fetchExecsByJobTitle');
            Route::get('/leaderboard/fetchExecsByCompetition', 'Admin\LeaderboardController@fetchExecsByCompetition');
            Route::get('/leaderboard/edit/{id}', 'Admin\LeaderboardController@edit')->name('admin.leaderboard.edit');
            Route::post('/leaderboard/update/{id}', 'Admin\LeaderboardController@update')->name('admin.leaderboard.update');
            Route::post('/leaderboard/add-users-to-competiton', 'Admin\LeaderboardController@addUsersToCompetiton')->name('admin.add.users.to.competition');
            Route::get('/leaderboard/delete/{id}', 'Admin\LeaderboardController@delete')->name('leaderboard.delete');
            Route::get('/leaderboard/sale-logs', 'Admin\LeaderboardController@salesLog')->name('leaderboard.sales.log');
            Route::get('/leaderboard/delete-log/{id}', 'Admin\LeaderboardController@deleteLog')->name('leaderboard.delete.log');
            Route::get('/leaderboard/edit-log/{id}/{competition_id}', 'Admin\LeaderboardController@editLog')->name('leaderboard.edit.log');
            Route::post('/leaderboard/update-log/{id}', 'Admin\LeaderboardController@updateLog')->name('admin.leaderboard.update.log');
        });

        //Wallpapers Routes
        Route::middleware(['role:super-admin'])->group(function () {
            Route::get('/wallpapers', 'Admin\WallpaperController@index')->name('admin.wallpaper.index');
            Route::get('/wallpapers/create', 'Admin\WallpaperController@create')->name('admin.wallpaper.create');
            Route::post('/wallpapers/store', 'Admin\WallpaperController@store')->name('admin.wallpaper.store');

            Route::get('/wallpapers/edit/{id}', 'Admin\WallpaperController@edit')->name('admin.wallpaper.edit');
            Route::post('/wallpapers/update/{id}', 'Admin\WallpaperController@update')->name('admin.wallpaper.update');
            Route::get('/wallpapers/delete/{id}', 'Admin\WallpaperController@delete')->name('wallpaper.delete');
            Route::post('/wallpaperPosition', 'Admin\WallpaperController@wallpaperPosition')->name('Wallpaper.position');

        });


        Route::middleware(['role:super'])->group(function () {
            Route::get('/leaderboard/upload', 'Admin\LeaderboardController@upload')->name('admin.leaderboard.upload');
        });

        //Site Configuration Controller
        ##########################################################################################
        Route::resource('/site-configuration', 'Admin\SiteConfigurationController')->middleware('role:super-admin;admin');

        //Search Controller
        Route::get('/search-vehicles', 'Admin\SearchableController@searchPotList')->name('admin.searchable.pot.list');
        Route::get('/search-vehicles/sale-date', 'Admin\SearchableController@searchSaleDate')->name('admin.searchable.sale.date');
        Route::get('/search-vehicles/last-work-date', 'Admin\SearchableController@searchLastWorkDate')->name('admin.searchable.last.work.date');


        //Log Viewer Controller
        ##########################################################################################
        Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('role:super');
    });

    //Password expired
    Route::GET('/password/expired', 'Auth\AdminExpiredPasswordController@expired')->name('admin.password.expired');
    Route::POST('/password/updated', 'Auth\AdminExpiredPasswordController@passwordUpdated')->name('admin.password.updated');

});
//End of Dashboard

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function(){
    return redirect()->route('book.dashboard');
});
