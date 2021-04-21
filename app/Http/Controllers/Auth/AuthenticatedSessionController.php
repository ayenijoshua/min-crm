<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\CompanyLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDO;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * dispay compay login view
     */
    public function createCompany()
    {
        return view('auth.company-login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $redirectUrl = $request->user()->is_admin 
        ? RouteServiceProvider::ADMIN_DASHBOARD 
        : RouteServiceProvider::USER_DASHBOARD;

        return response(['redirect_url'=>$redirectUrl,'success'=>true],302);
    }

    /**
     * authenticate company
     */
    public function storeCompany(CompanyLoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response(['redirect_url'=>RouteServiceProvider::COMPANY_DASHBOARD,'success'=>true],302);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
