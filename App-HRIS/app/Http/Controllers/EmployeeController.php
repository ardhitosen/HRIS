<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Announcement;
use App\Models\Transfer;
use App\Models\Event;
use App\Models\Attendance;
use App\Models\Overtime;
use App\Models\Timeoff;
use App\Models\Scheduler;
use Illuminate\Support\Facades\Log;
use App\Models\Employee;
use App\Models\Reimbursement;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $employee = Employee::where('username', $credentials['username'])->first();

        // $hCaptchaResponse = $request->input('h-captcha-response');
        // $secretKey = '0x5aDe1898FcA3C3ebdd7837EEAa8Baf6cBa1C7fB0';

        // $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
        //     'response' => $hCaptchaResponse,
        //     'secret' => $secretKey,
        // ]);

        // $responseData = $response->json();
        // if (!$responseData['success']) {
        //     return redirect()->back()->withErrors('Invalid captcha');
        // }

        if ($employee && Hash::check($credentials['password'], $employee->password)) {
            Session::start();
            Session::put('employee', $employee);
            return redirect()->route('frontend_dashboard');
        } else {
            return redirect()->back()->withErrors('Invalid credentials');
        }
    }
    
    public function logout() 
    {
        Session::flush();
        return redirect()->route('index_frontend');
    }

    public function dashboard()
    {
        return view('frontend.dashboard');
    }

}
