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

    public function overtime()
    {
        $user_id = session('employee')->id;
        $overtime = [];
        $overtime = Overtime::where('employee_id',$user_id)->get();
        return view('frontend.timeManagement.overtime',['overtime'=>$overtime]);
    }

    public function overtimeadd(Request $request)
    {
        $user_id = session('employee')->id;
        $validator = Validator::make($request->all(), [
            'scheduleDate' => 'required|date',
            'scheduleTime' => 'required|numeric',
            'description' => 'required',
            'overtimeWork' => 'required|file'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = session('employee')->id;
        $filePath = $request->file('overtimeWork')->store('overtime_files');
        $overtime = new Overtime();
        $overtime->employee_id = $user_id;
        $overtime->overtime_date = $request->input('scheduleDate');
        $overtime->duration = $request->input('scheduleTime');
        $overtime->description = $request->input('description');
        $overtime->file = $filePath;
        $overtime->status = "Pending";
        $overtime->save();

        return redirect()->route('frontend_overtime');
    }

    public function attendance()
    {
        $today = Carbon::now()->toDateString();
        $user_id = session('employee')->id;
        $attendance = [];
        $attendance = Attendance::orderBy('attendance_id', 'desc')->where('employee_id',$user_id)->where('date',$today)->first();
        return view('frontend.timeManagement.attendance', ['attendance' => $attendance]);
        
    }

    public function clockIn()
    {
        $today = Carbon::now()->toDateString();
        $time = Carbon::now()->toTimeString();
        $user_id = session('employee')->id;

        $attendance = Attendance::orderBy('attendance_id', 'desc')->where('employee_id',$user_id)->where('date',$today)->first();
        $attendance->clock_in = $time;
        $attendance->save();
        return redirect()->route('frontend_attendance');
    }

    public function clockOut()
    {
        $today = Carbon::now()->toDateString();
        $time = Carbon::now()->toTimeString();
        $user_id = session('employee')->id;

        $attendance = Attendance::orderBy('attendance_id', 'desc')->where('employee_id',$user_id)->where('date',$today)->first();
        $attendance->clock_out = $time;
        $attendance->save();
        return redirect()->route('frontend_attendance');
    }

    public function timeoff()
    {
        $user_id = session('employee')->id;

        $timeoff=[];
        $timeoff = Timeoff::where('employee_id',$user_id)->get();

        return view('frontend.timeManagement.timeoff',['timeoff'=>$timeoff]);
    }

    public function timeoffAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'effectiveDate' => 'required|date',
            'expDate' => 'required|date',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = session('employee')->id;

        $newTimeOff = new Timeoff();
        $newTimeOff->employee_id = $user_id;
        $newTimeOff->effective_date = $request->input('effectiveDate');
        $newTimeOff->expiration_date = $request->input('expDate');
        $newTimeOff->status = "Pending";
        $newTimeOff->save();

        return redirect()->route('frontend_timeoff');
    }

    public function announcement()
    {
        $announcements = Announcement::all();
        return view('frontend.announcement',['announcements' => $announcements]);
    }

    public function show_profile() 
    {
        $employee = Employee::where('id', session('employee')->id);
        return view('frontend.profile', ['employee'=>$employee]);
    }
}