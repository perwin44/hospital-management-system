<?php

use App\Events\MyEvent;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard\AmbulanceController;
use App\Http\Controllers\Dashboard\appointments\AppointmentController;
use App\Http\Controllers\Dashboard\DashboardController;
//use App\Http\Controllers\Auth\DoctorController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\InsuranceController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\PaymentAccountController;
use App\Http\Controllers\Dashboard\RayEmployeeController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ReceiptAccountController;
use App\Http\Controllers\Dashboard\LaboratorieEmployeeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/Dashboard_Admin',[DashboardController::class,'index']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        ////////dashboard user ///////

        Route::get('/dashboard_user', function () {
            return view('Dashboard.User.dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard_user');
            ////////end dashboard user ///////




        ///////dashboard admin /////////

        Route::get('/dashboard_admin', function () {

            return view('Dashboard.Admin.dashboard');
        })->middleware(['auth:admin', 'verified'])->name('dashboard_admin');
        Route::middleware('auth:admin')->group(function(){
            Route::post('logout/admin', [AdminController::class, 'destroy'])->name('logout.admin');
        });

        ///////end dashboard admin /////////




        //---------------------------------

        Route::middleware(['auth:admin'])->group(function(){
            ////// section route/////
            Route::resource('Sections',SectionController::class);
            ////////end section route///////


            ///////Doctor route///////
            Route::resource('Doctors',DoctorController::class);
            Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
            Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');
            ////////end Doctor route////


              //############################# sections route ##########################################

        Route::resource('Service', SingleServiceController::class);

        //############################# end sections route ######################################


          //############################# GroupServices route ##########################################

          Route::view('Add_GroupServices','livewire.GroupServices.include_create')->name('Add_GroupServices');

          //############################# end GroupServices route ######################################


          \Livewire\Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });


         //############################# insurance route ##########################################

         Route::resource('insurance', InsuranceController::class);

         //############################# end insurance route ######################################


           //############################# Ambulance route ##########################################

        Route::resource('Ambulance', AmbulanceController::class);

        //############################# end Ambulance route ######################################


         //############################# Patients route ##########################################

         Route::resource('Patients', PatientController::class);

         //############################# end Patients route ######################################


 //############################# single_invoices route ##########################################

 Route::view('single_invoices','livewire.single_invoices.index')->name('single_invoices');

 Route::view('Print_single_invoices','livewire.single_invoices.print')->name('Print_single_invoices');

 //############################# end single_invoices route ######################################


   //############################# Receipt route ##########################################

   Route::resource('Receipt', ReceiptAccountController::class);

   //############################# end Receipt route ######################################


      //############################# Payment route ##########################################

      Route::resource('Payment', PaymentAccountController::class);

      //############################# end Payment route ######################################


       //############################# group_invoices route ##########################################

       Route::view('group_invoices','livewire.Group_invoices.index')->name('group_invoices');

       Route::view('group_Print_single_invoices','livewire.Group_invoices.print')->name('group_Print_single_invoices');

       //############################# end group_invoices route ######################################



        //############################# RayEmployee route ##########################################

        Route::resource('ray_employee', RayEmployeeController::class);

        //############################# end RayEmployee route ######################################

           //############################# laboratorie_employee route ##########################################

           Route::resource('laboratorie_employee', LaboratorieEmployeeController::class);

           //############################# end laboratorie_employee route ######################################

           Route::get('appointments',[AppointmentController::class,'index'])->name('appointments.index');
           Route::put('appointments/approval/{id}',[AppointmentController::class,'approval'])->name('appointments.approval');
           Route::get('appointments/approval',[AppointmentController::class,'index2'])->name('appointments.index2');

        });















        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        require __DIR__.'/auth.php';


    });



