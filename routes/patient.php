<?php


use App\Http\Controllers\Dashboard_Doctor\DiagnosticController;
use App\Http\Controllers\Dashboard_Doctor\LaboratorieController;
use App\Http\Controllers\Dashboard_Doctor\RayController;
use App\Http\Controllers\Dashboard_Doctor\PatientDetailsController;
use App\Http\Controllers\Auth\PatientController;
use App\Http\Controllers\Dashboard_Patient\PatienttController;
use App\Http\Controllers\Dashboard_Ray_Employee\InvoiceController;
use App\Livewire\Chat\Createchat;
use App\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| doctor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    //################################ dashboard patient ########################################
    Route::get('/dashboard_patient', function () {
        return view('Dashboard.dashboard_patient.dashboard');
    })->middleware(['auth:patient'])->name('dashboard.patient');

    Route::post('/logout/patient', [PatientController::class, 'destroy'])->middleware('auth:patient')->name('logout.patient');
    //################################ end dashboard patient #####################################

    Route::middleware(['auth:patient'])->group(function () {
        //############################# patients route ##########################################
        Route::get('invoices', [PatienttController::class,'invoices'])->name('invoices.patient');
        Route::get('laboratories', [PatienttController::class,'laboratories'])->name('laboratories.patient');
        Route::get('view_laboratories/{id}', [PatienttController::class,'viewLaboratories'])->name('laboratories.view');
        Route::get('rays', [PatienttController::class,'rays'])->name('rays.patient');
        Route::get('view_rays/{id}', [PatienttController::class,'viewRays'])->name('rays.view');
        Route::get('payments', [PatienttController::class,'payments'])->name('payments.patient');
        //############################# end patients route ######################################


        // LIVEWIRE //
        \Livewire\Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });

        //############################# Chat route ##########################################
         Route::get('list/doctors',CreateChat::class)->name('list.doctors');
         Route::get('chat/doctors',Main::class)->name('chat.doctors');
        //############################# end Chat route ######################################
    });


    require __DIR__ . '/auth.php';

});
