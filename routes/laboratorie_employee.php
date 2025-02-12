<?php

use App\Http\Controllers\Auth\LaboratorieEmployeeController;
use App\Http\Controllers\Dashboard_Laboratorie_Employee\InvoiceController;
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


    //################################ dashboard laboratorie ########################################

    Route::get('/dashboard_laboratorie_employee', function () {
        return view('Dashboard.dashboard_LaboratorieEmployee.dashboard');
    })->middleware(['auth:laboratorie_employee'])->name('dashboard.laboratorie_employee');

    Route::post('/logout/laboratorie_employee', [LaboratorieEmployeeController::class, 'destroy'])->middleware('auth:laboratorie_employee')->name('logout.laboratorie_employee');
    //################################ end dashboard laboratorie #####################################

    Route::middleware(['auth:laboratorie_employee'])->group(function () {

    //############################# invoices route ##########################################
     Route::resource('invoices_laboratorie_employee', InvoiceController::class);
     Route::get('completed_invoices', [InvoiceController::class,'completed_invoices'])->name('completed_invoices');
     Route::get('view_laboratories/{id}', [InvoiceController::class,'view_laboratories'])->name('view_laboratories');
    //############################# end invoices route ######################################

    });



//---------------------------------------------------------------------------------------------------------------


    require __DIR__ . '/auth.php';

});
