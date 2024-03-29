<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Overtime;
use App\Models\Timeoff;
use Illuminate\Support\Facades\Log;
use App\Models\Scheduler;
use App\Models\Employee;
use App\Models\Reimbursement;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;
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

        if ($employee && Hash::check($credentials['password'], $employee->password)) {
            Session::start();
            Session::put('employee', $employee);
            Auth::guard('employee')->login($employee);

            return redirect()->route('frontend_dashboard');
        } else {
            return redirect()->back()->withErrors('Invalid credentials');
        }
    }
    
    public function logout() 
    {
        Session::flush();
        Auth::guard('employee')->logout();
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
        $attendance = Attendance::where('employee_id', session('employee')->id)->first();
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
        $filePath = $request->file('overtimeWork')->storeAs($request->file('overtimeWork')->getClientOriginalName());
        $overtime = new Overtime();
        $overtime->employee_id = $user_id;
        $overtime->overtime_date = $request->input('scheduleDate');
        $scheduleOut = Carbon::parse($attendance->schedule_out);
        $newTime = $scheduleOut->addSeconds($request->scheduleTime * 3600)->format('H:i:s');
        $overtime->duration = $newTime;
        $overtime->description = $request->input('description');
        $overtime->file = $filePath;
        $overtime->status = "Pending";
        $overtime->save();

        return redirect()->route('frontend_overtime');
    }

    public function overtimeFileDownload($filename)
    {
        $filePath = storage_path('app/' . $filename);

        if (Storage::exists($filename)) {
            return response()->download($filePath, $filename, [
                'Content-Type' => mime_content_type($filePath),
            ]);
        } else {
            abort(404, 'File not found');
        }
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

    public function reimbursement()
    {
        $user_id = session('employee')->id;

        $reimbursement= Reimbursement::where('employee_id',$user_id)->get();
        return view('frontend.timeManagement.reimbursement',['reimbursement'=>$reimbursement]);

    }

    public function reimbursement_create(Request $request)
    {
        $reimbursement = new Reimbursement();
        $reimbursement->employee_id = session('employee')->id;
        $reimbursement->reimbursement_type = $request->input('reimbursement_type');
        $reimbursement->total_reimbursement = $request->input('reimburse');
        $reimbursement->status = "Pending";
        $reimbursement->proof = file_get_contents($request->proof);
        $reimbursement->save();

        return redirect()->route('frontend_reimbursement'); 
    }

    public function announcement()
    {
        $announcements = Announcement::all();
        $schedules = Scheduler::where('employee_id', session('employee')->id)->get();
        return view('frontend.announcement',['announcements' => $announcements, 'schedules' => $schedules]);
    }

    public function show_profile() 
    {
        $employee = Employee::where('id', session('employee')->id);
        return view('frontend.profile', ['employee'=>$employee]);
    }
}