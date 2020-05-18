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

// HOMEPAGE
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/index', 'HomePageController@show')->name('home');

// INITIATIEF VERSTUREN
Route::get('/initiatief', 'initiativeController@show')->name('initiative');
Route::get('/initiatief/zoek', 'initiativeController@searchWithFilter')->name('initiative.search');
Route::get('/initiatief/nieuw', 'initiativeController@create')->name('initiative.create');
Route::get('/initiatief/succes', 'initiativeController@success')->name('initiative.success');
Route::post('/initiatief/nieuw', 'initiativeController@store')->name('initiative.store');

// CONTACT
Route::get('/contact', 'ContactController@create');
Route::post('/contact', 'ContactController@store');

// HELP MEE
Route::get('/help-mee', 'HelpOutController@index')->name('help-out');
Route::get('/help-mee/zoek', 'HelpOutController@searchWithFilter')->name('help-out.search');

// APPLICATION VERSTUREN
Route::get('applications/create/{id}', [
    'as' => 'applications.create',
    'uses' => 'ApplicationController@create'
]);

Route::post('applications/store/', [
    'as' => 'applications.store',
    'uses' => 'ApplicationController@store'
]);

//<editor-fold desc="Donaties bezoeker">

// DONATIES PRODUCT VOOR INITIATIEF
Route::get('/donatie/product/{id}', 'DonationController@createProduct')->name('donation-product');
Route::post('/donatie/product/', 'DonationController@storeProduct')->name('donation-product-store');

// DONATIES GELD VOOR EEN INITIATIEF
Route::get('/donatie/doel/{id}', 'DonationController@createMoney')->name('donation-money');
Route::post('/donatie/doel/', 'DonationController@storeMoney')->name('donation-money-store');

// DONATIES STANDAARD VOOR GELD
Route::get('/donatie/geld/', 'DonationController@createNormal')->name('donation-normal');

// DONATIES OVERZICHT PAGINA
Route::get('/donatie/overzicht/', 'DonationController@showOverview')->name('donation-overview');
Route::get('/donatie/overzicht/zoek', 'DonationController@showOverviewFilter')->name('donation-overview-search');

//DONATIES VERSTUURT PAGINA
Route::get('/donatie/bedankt/', 'DonationController@showReceived')->name('donation-received');

//</editor-fold>

// INITIATIEF DETAILS
Route::get('/initiatiefdetails/{id}', 'initiativeDetailsController@show')->name('initiativeDetails');

// AUTHENTICATIE
Auth::routes();

// BEHEERSYSTEEM
Route::get('/accountbeheer', 'cms\CMSUserController@index')->name('accountbeheer');

Route::resource('users', 'cms\CMSUserController');

Route::get('/cms/cms-dashboard', 'cms\CMSHomeController@show')->middleware('auth')->name('cms-home');

// ROOSTER CMS
Route::get('/rooster', 'cms\CMSScheduleController@index')->middleware('auth')->name('cms-schedule-home');
Route::post('/rooster', 'cms\CMSScheduleController@store')->middleware('auth')->name('schedule-store');
Route::get('/rooster/create/{date}', 'cms\CMSScheduleController@create')->middleware('auth')->name('schedule-create');
Route::get('/rooster/{initiative}/edit', 'cms\CMSScheduleController@edit')->middleware('auth')->name('schedule-edit');
Route::put('/rooster/{initiative}', 'cms\CMSScheduleController@update')->middleware('auth')->name('schedule-update');
Route::get('/rooster/{initiative}/destroy', 'cms\CMSScheduleController@destroy')->middleware('auth')->name('schedule-destroy');
Route::get('/rooster/{year}/{month}', 'cms\CMSScheduleController@showyeardate')->middleware('auth')->name('cms-schedule-yeardate');
Route::get('/rooster/export', 'cms\CMSScheduleController@exportimg')->middleware('auth')->name('schedule-exportimg');


// ACTIVITEITEN
Route::get('/cms/initiatieven', 'cms\CMSActivityController@index')->name('activities');
Route::get('/cms/initiatieven/create', 'cms\CMSActivityController@create')->name('activities.create');
Route::post('/cms/initiatieven/store', 'cms\CMSActivityController@store')->name('activities.store');
Route::get('/cms/initiatieven/{initiatief}/edit', 'cms\CMSActivityController@edit')->name('activities.edit');
Route::put('/cms/initiatieven/{initiatief}', 'cms\CMSActivityController@update')->name('activities.update');
Route::delete('/cms/initiatieven/{initiatief}', 'cms\CMSActivityController@destroy')->name('activities.destroy');
Route::get('/cms/initiatieven/create/{id}', 'cms\CMSActivityController@createAutofill')->name('activities.createAutofill');

Route::resource('passwordforgot', 'cms\CMSUserController');

Route::resource('inbox', 'cms\CMSInboxController')->only(['index', 'show', 'destroy', 'update']);

Route::resource('send_initiative', 'cms\CMSSendInitiativeController');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');



// VACANCY/APPLICATION
Route::get('/cms/vacatures', 'cms\CMSVacancyController@index')->name('cms-vacancy');
Route::get('/cms/vacatures/nieuw', 'cms\CMSVacancyController@create')->name('cms-vacancy.create');
Route::delete('/cms/vacatures/verwijder/{vacancy}', 'cms\CMSVacancyController@destroy')->name('cms-vacancy.destroy');
Route::delete('/cms/vacatures/{application}', 'cms\CMSVacancyController@destroyApplication')->name('cms-vacancyApplication.destroy');
Route::post('/cms/vacatures/nieuw', 'cms\CMSVacancyController@store')->name('cms-vacancy.create');
Route::get('/cms/vacatures/wijzigen/{vacancy}', 'cms\CMSVacancyController@edit')->name('cms-vacancy.edit');
Route::post('/cms/vacatures/wijzigen/{vacancy}', 'cms\CMSVacancyController@update')->name('cms-vacancy.update');
Route::get('/cms/vacatures/aanmelding/{application}', 'cms\CMSVacancyController@show')->name('cms-vacancy.show');
Route::post('/cms/vacatures/aanmelding/{application}', 'cms\CMSVacancyController@acceptApplication')->name('cms-vacancy.acceptApplication');

// SPONSORS CMS
Route::get('/cms/sponsor', 'cms\CMSSponsorController@index')->name('cms-sponsor');
Route::get('/cms/sponsor/nieuw', 'cms\CMSSponsorController@create')->name('cms-sponsor.create');
Route::delete('/cms/sponsor/verwijder/{sponsor}', 'cms\CMSsponsorController@destroy')->name('cms-sponsor.destroy');
Route::get('/cms/sponsor/wijzigen/{sponsor}', 'cms\CMSSponsorController@edit')->name('cms-sponsor.edit');
Route::post('/cms/sponsor/nieuw', 'cms\CMSSponsorController@store')->name('cms-sponsor.store');
Route::put('/cms/sponsor/wijzigen/{sponsor}', 'cms\CMSSponsorController@update')->name('cms-sponsor.update');

// SPONSORS
Route::get('/sponsoren&partners', 'SponsorController@index')->name('sponsor');

// OPENINGSTIJDEN
Route::get('/openingstijden', 'OpeningHoursController@show')->name('openingHours');

// CONTENT
Route::get('/cms/content', 'cms\CMSContentController@index')->name('cms-content');
Route::get('/cms/content/hoofdpagina', 'cms\CMSContentController@editHomepage')->name('cms-content-homepage.edit');
Route::put('/cms/content/hoofdpagina', 'cms\CMSContentController@updateHomepage')->name('cms-content-homepage.update');
Route::get('/cms/content/initiatief', 'cms\CMSContentController@editInitiative')->name('cms-content-initiative.edit');
Route::put('/cms/content/initiatief', 'cms\CMSContentController@updateInitiative')->name('cms-content-initiative.update');
Route::get('/cms/content/contact', 'cms\CMSContentController@editContact')->name('cms-content-contact.edit');
Route::put('/cms/content/contact', 'cms\CMSContentController@updateContact')->name('cms-content-contact.update');
Route::get('/cms/content/openingstijden', 'cms\CMSContentController@editOpeningHours')->name('cms-content-openingHours.edit');
Route::put('/cms/content/openingstijden', 'cms\CMSContentController@updateOpeningHours')->name('cms-content-openingHours.update');
Route::get('/cms/content/overig', 'cms\CMSContentController@editOther')->name('cms-content-other.edit');
Route::put('/cms/content/overig', 'cms\CMSContentController@updateOther')->name('cms-content-other.update');

// DONATIONS

Route::prefix('/cms')->group(function() {
    Route::get('/donaties/aanvraag', 'cms\CMSDonationController@create')->name('donationRequest.create');
    Route::post('/donaties/aanvraag', 'cms\CMSDonationController@store')->name('donationRequest.store');
    Route::get('/donaties/aanvraag/zoek', 'cms\CMSDonationController@search')->name('donationRequest.search');
    Route::get('/donaties/aanvraag/{donationRequest}', 'cms\CMSDonationController@edit')->name('donationRequest.edit');
    Route::put('/donaties/aanvraag/{donationRequest}', 'cms\CMSDonationController@update')->name('donationRequest.update');
    Route::delete('/donaties/aanvraag/{donationRequest}', 'cms\CMSDonationController@destroyRequest')->name('donationRequest.destroy');

    Route::get('/donaties', 'cms\CMSDonationController@index')->name('donations.index');
    Route::get('/donaties/{donation}', 'cms\CMSDonationController@showDonation')->name('donations.show');
    Route::put('/donaties/{donation}', 'cms\CMSDonationController@acceptDonation')->name('donations.accept');
    Route::delete('/donaties/{donation}', 'cms\CMSDonationController@destroyDonation')->name('donations.destroy');
});


Route::fallback(function () {
    abort(404);
});
