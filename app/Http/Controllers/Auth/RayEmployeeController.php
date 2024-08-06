<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\Auth\RayEmployeeLoginRequest;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class RayEmployeeController extends Controller
{
    public function store(RayEmployeeLoginRequest $request)
    {

        if($request->authenticate()){
            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::RayEmployee);
        }

        return redirect()->back()->withErrors(['name'=>(trans('Dashboard/auth.failed'))]);
        //return redirect()->back()->withErrors(['name'=>'يوجد خطا في كلمة المرور او اسم المستخدم']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Auth::guard('ray_employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
