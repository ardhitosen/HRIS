<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Announcement;
use Illuminate\Support\Facades\Log;
use App\Models\Employee;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;

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
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors('Invalid credentials');
        }
    }

    public function dashboard()
    {
        $employee = Employee::all();
        $empCount = 0;
        $today = Carbon::now();

        $year = [];
        $male = 0;
        $female = 0;
        $activeStaff = 0;
        foreach ($employee as $employee) {
            if (isset($employee->id)) $empCount++;
            if (!isset($employee->resign_date)) $activeStaff++;
            $employee->gender == "Male" ? $male++ : $female++;
            $interval = Carbon::parse($employee->join_date)->diff($today);
            $year[] = $interval->y;
        }
        return view(
            'dashboard',
            ['empCount' => $empCount, 'year' => $year, 'male' => $male, 'female' => $female, 'activeStaff' => $activeStaff]
        );
    }

    public function logoutProcess()
    {
        return redirect()->route('index');
    }

    public function employee()
    {
        $employee = Employee::all();
        $employeeData = [];
        foreach ($employee as $employee) {
            $employeeData[] = [
                'id' => $employee->id,
                'username' => $employee->username,
                'password' => $employee->password,
                'name' => $employee->name,
                'branch' => $employee->branch,
                'organization' => $employee->organization,
                'job_position' => $employee->job_position,
                'job_level' => $employee->job_level,
                'barcode' => $employee->barcode,
                'email' => $employee->email,
                'join_date' => $employee->join_date,
                'sign_date' => $employee->sign_date,
                'birth_date' => $employee->birth_date,
                'resign_date' => $employee->resign_date,
                'birth_place' => $employee->birth_place,
                'address' => $employee->address,
                'mobile_phone' => $employee->mobile_phone,
                'religion' => $employee->religion,
                'gender' => $employee->gender,
                'marital_status' => $employee->marital_status,
                'salary' => $employee->salary,
                'employment_status' => $employee->employment_status,
            ];
        }

        return view('employee.employee', ['employee' => $employeeData]);
    }

    public function addEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:employees,username',
            'password' => 'required',
            'name' => 'required',
            'branch' => 'required',
            'organization' => 'required',
            'jobposition' => 'required',
            'joblevel' => 'required',
            'barcode' => 'required|unique:employees,barcode',
            'email' => 'required|email|unique:employees,email',
            'joindate' => 'required|date',
            'signdate' => 'required|date',
            'birthdate' => 'required|date',
            'birthplace' => 'required',
            'address' => 'required',
            'mobilephone' => 'required',
            'religion' => 'required',
            'gender' => 'required|in:Male,Female',
            'maritalstatus' => 'required|in:Single,Married,Divorced,Widowed',
            'salary' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = new Employee();
        $employee->username = $request->input('username');
        $employee->password = bcrypt($request->input('password'));
        $employee->name = $request->input('name');
        $employee->branch = $request->input('branch');
        $employee->organization = $request->input('organization');
        $employee->job_position = $request->input('jobposition');
        $employee->job_level = $request->input('joblevel');
        $employee->barcode = $request->input('barcode');
        $employee->resign_date = null;
        $employee->email = $request->input('email');
        $employee->join_date = $request->input('joindate');
        $employee->sign_date = $request->input('signdate');
        $employee->birth_date = $request->input('birthdate');
        $employee->birth_place = $request->input('birthplace');
        $employee->address = $request->input('address');
        $employee->mobile_phone = $request->input('mobilephone');
        $employee->religion = $request->input('religion');
        $employee->gender = $request->input('gender');
        $employee->marital_status = $request->input('maritalstatus');
        $employee->salary = $request->input('salary');
        $employee->employment_status = "Employed";

        $employee->save();

        return redirect()->route('dashboard');
    }

    public function resign(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->resign_date = date('Y-m-d');
        $employee->save();
        return redirect()->route('employee');
    }
    public function attendance()
    {
        $employee = Employee::all();
        $employeeData = [];
        
        foreach ($employee as $employee) {
            $employeeData[] = [
                'id' => $employee->id,
                'username' => $employee->username,
                'password' => $employee->password,
                'name' => $employee->name,
                'branch' => $employee->branch,
                'organization' => $employee->organization,
                'job_position' => $employee->job_position,
                'job_level' => $employee->job_level,
                'barcode' => $employee->barcode,
                'email' => $employee->email,
                'join_date' => $employee->join_date,
                'sign_date' => $employee->sign_date,
                'birth_date' => $employee->birth_date,
                'resign_date' => $employee->resign_date,
                'birth_place' => $employee->birth_place,
                'address' => $employee->address,
                'mobile_phone' => $employee->mobile_phone,
                'religion' => $employee->religion,
                'gender' => $employee->gender,
                'marital_status' => $employee->marital_status,
                'salary' => $employee->salary,
                'employment_status' => $employee->employment_status,
            ];
        }

        $today = Carbon::parse(Carbon::now());
        $todayFormat = $today->format('d M Y');
        return view('timeManagement.attendance', ['employee' => $employeeData, 'today' => $todayFormat]);
    }

    public function calendar()
    {
        return view('timeManagement.calendar');
    }

    public function overtime()
    {
        return view('timeManagement.overtime');
    }

    public function scheduler()
    {
        $employee = Employee::all();
        $employeeData = [];
        
        foreach ($employee as $employee) {
            $employeeData[] = [
                'id' => $employee->id,
                'username' => $employee->username,
                'password' => $employee->password,
                'name' => $employee->name,
                'branch' => $employee->branch,
                'organization' => $employee->organization,
                'job_position' => $employee->job_position,
                'job_level' => $employee->job_level,
                'barcode' => $employee->barcode,
                'email' => $employee->email,
                'join_date' => $employee->join_date,
                'sign_date' => $employee->sign_date,
                'birth_date' => $employee->birth_date,
                'resign_date' => $employee->resign_date,
                'birth_place' => $employee->birth_place,
                'address' => $employee->address,
                'mobile_phone' => $employee->mobile_phone,
                'religion' => $employee->religion,
                'gender' => $employee->gender,
                'marital_status' => $employee->marital_status,
                'salary' => $employee->salary,
                'employment_status' => $employee->employment_status,
            ];
        }

        return view('timeManagement.scheduler', ['employee' => $employeeData]);
    }

    public function timeoff()
    {$employee = Employee::all();
        $employeeData = [];
        
        foreach ($employee as $employee) {
            $employeeData[] = [
                'id' => $employee->id,
                'username' => $employee->username,
                'password' => $employee->password,
                'name' => $employee->name,
                'branch' => $employee->branch,
                'organization' => $employee->organization,
                'job_position' => $employee->job_position,
                'job_level' => $employee->job_level,
                'barcode' => $employee->barcode,
                'email' => $employee->email,
                'join_date' => $employee->join_date,
                'sign_date' => $employee->sign_date,
                'birth_date' => $employee->birth_date,
                'resign_date' => $employee->resign_date,
                'birth_place' => $employee->birth_place,
                'address' => $employee->address,
                'mobile_phone' => $employee->mobile_phone,
                'religion' => $employee->religion,
                'gender' => $employee->gender,
                'marital_status' => $employee->marital_status,
                'salary' => $employee->salary,
                'employment_status' => $employee->employment_status,
            ];
        }
        
        return view('timeManagement.timeoff', ['employee' => $employeeData]);
    }

    public function announcement()
    {
        $announcements = Announcement::all();

        return view('announcement', ['announcements' => $announcements]);
    }

    public function create_announcement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $announcement = new Announcement();
        $announcement->announcement = $request->title;
        $announcement->description = $request->description;
        $announcement->save();

        return redirect()->route('announcement');
    }

    public function payroll()
    {
        return view('payroll');
    }

    public function reimbursement()
    {
        return view('reimbursement');
    }

    public function employeeDetail($id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();

        return view('employee.employeeDetail', ['employee' => $employee]);
    }

    public function employeeEmployment($id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();

        return view('employee.employeeEmployment', ['employee' => $employee]);
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
