<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
            return view('index');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $admin = Admin::where('username', $credentials['username'])->first();

        $hCaptchaResponse = $request->input('h-captcha-response');
        $secretKey = '0x5aDe1898FcA3C3ebdd7837EEAa8Baf6cBa1C7fB0';

        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'response' => $hCaptchaResponse,
            'secret' => $secretKey,
        ]);

        $responseData = $response->json();
        if (!$responseData['success']) {
            return redirect()->back()->withErrors('Invalid captcha');
        }

        if ($admin && $credentials['password'] == $admin->password) {
            return redirect()->intended('admins/dashboard');
        } else {
            return redirect()->back()->withErrors('Invalid credentials');
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logoutProcess()
    {
        return redirect()->route('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
