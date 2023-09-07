<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Announcement;
use App\Models\Transfer;
use App\Models\Attendance;
use App\Models\Timeoff;
use App\Models\Scheduler;
use Illuminate\Support\Facades\Log;
use App\Models\Employee;
use App\Models\Reimbursement;
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
                'email' => $employee->email,
                'join_date' => $employee->join_date,
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
            'email' => 'required|email|unique:employees,email',
            'joindate' => 'required|date',
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
        $employee->resign_date = null;
        $employee->email = $request->input('email');
        $employee->join_date = $request->input('joindate');
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

    public function editEmployee(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'organization' => 'required',
            'email' => 'required|unique:employees,email,'.$id.',id',
            'birthdate' => 'required|date',
            'birthplace' => 'required',
            'joindate' => 'required|date',
            'address' => 'required',
            'mobilephone' => 'required',
            'religion' => 'required',
            'gender' => 'required|in:Male,Female',
            'maritalstatus' => 'required|in:Single,Married,Divorced,Widowed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = Employee::findOrFail($id);
        $employee->name = $request->input('name');
        $employee->organization = $request->input('organization');
        $employee->email = $request->input('email');
        $employee->join_date = $request->input('joindate');
        $employee->birth_date = $request->input('birthdate');
        $employee->birth_place = $request->input('birthplace');
        $employee->address = $request->input('address');
        $employee->mobile_phone = $request->input('mobilephone');
        $employee->religion = $request->input('religion');
        $employee->gender = $request->input('gender');
        $employee->marital_status = $request->input('maritalstatus');

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
                'name' => $employee->name,
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

        foreach ($employee as $emp) {
            $scheduler = Scheduler::where('employee_id', $emp->id)->first();
            
            $employeeData[] = [
                'id' => $emp->id,
                'name' => $emp->name,
                'branch' => $emp->branch,
                'organization' => $emp->organization,
                'job_position' => $emp->job_position,
                'job_level' => $emp->job_level,
                'employment_status' => $emp->employment_status,
                'current_schedule' => $scheduler ? $scheduler->current_schedule : null,
                'schedule_time' => $scheduler ? $scheduler->schedule_time : null,
                'schedule_description' => $scheduler ? $scheduler->schedule_detail : null,
            ];
        }

        return view('timeManagement.scheduler', ['employee' => $employeeData]);
    }
    
    public function assignScheduler(Request $request)
    {
        $scheduler = new Scheduler();
        $scheduler->employee_id = $request->employee_id;
        $scheduler->current_schedule = $request->scheduleDate;
        $scheduler->schedule_time = $request->scheduleTime;
        $scheduler->schedule_detail = $request->description;
        $scheduler->save();
        
        return redirect()->route('scheduler');
    }

    public function timeoff()
    {
        $employee = Employee::all();
        $employeeData = [];

        $timeoff = Timeoff::all();
        $timeoffData = [];
        
        foreach($employee as $employee) {
            $employeeData[] = [
                'id' => $employee->id,
                'name' => $employee->name
            ];
        }

        foreach ($timeoff as $timeoff) {
            $emp = Employee::where('id', $timeoff->employee_id)->firstOrFail();

            $timeoffData[] = [
                'timeoff_id' => $timeoff->timeoff_id,
                'id' => $timeoff->employee_id,
                'employee_name' => $emp->name,
                'time_off_code' => $timeoff->time_off_code,
                'effective_date' => $timeoff->effective_date,
                'expiration_date' => $timeoff->expiration_date,
                'status' => $timeoff->status
            ];
        }

        return view('timeManagement.timeoff', ['employee' => $employeeData, 'timeoff' => $timeoffData]);
    }

    public function statusChange($status, $id) {
        $timeoff = Timeoff::findOrFail($id);

        // $timeoff->status = $status;
        // $timeoff->update(['status' => $status]);
        $timeoff->status = $status;
        $timeoff->save();
        
        return redirect()->route('timeoff');
    }

    public function timeoffAssign(Request $request) {
        $newTimeOff = new Timeoff();
        $newTimeOff->employee_id = $request->input('employee_id');
        $newTimeOff->time_off_code = $request->input('timeoffcode');
        $newTimeOff->effective_date = $request->input('effectiveDate');
        $newTimeOff->expiration_date = $request->input('expDate');
        $newTimeOff->status = "Pending";
        $newTimeOff->save();

        return redirect()->route('timeoff');
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

    public function editannouncement(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $announcement = Announcement::findOrFail($id);
        $announcement->announcement = $request->input('title');
        $announcement->description = $request->input('description');
        $announcement->save();

        return redirect()->route('announcement');
    }

    public function deleteannouncement(Request $request,$id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('announcement');
    }

    public function payroll()
    {
        $employee = Employee::all();
        return view('payroll', ['employee' => $employee]);
    }

    public function reimbursement()
    {
        $employee = Employee::all();
        $employeeData = [];

        foreach($employee as $employee) {
            $employeeData[] = [
                'id' => $employee->id,
                'name' => $employee->name
            ];
        }
        $reimbursement = Reimbursement::all();
        $reimbursementData = [];

        foreach ($reimbursement as $reimbursement) {
            // $employee = Employee::where('id', $reimbursement->employee_id)->firstOrFail();

            $reimbursementData[] = [
                'name' => $employee->name,
                'id' => $reimbursement->reimburse_id,
                'employee_id' => $reimbursement->employee_id,
                'reimbursement_type' => $reimbursement->reimbursement_type,
                'total_reimbursement' => $reimbursement->total_reimbursement,
                'status' => $reimbursement->status,
            ];
        }

        return view('reimbursement', ['reimbursement' => $reimbursementData, 'employee' => $employeeData]);
    }

    public function createReimbursement(Request $request)
    {
        $reimbursement = new Reimbursement();
        $reimbursement->employee_id = $request->input('employee_id');
        $reimbursement->reimbursement_type = $request->input('reimbursement_type');
        $reimbursement->total_reimbursement = $request->input('reimburse');
        $reimbursement->status = "Pending";
        $reimbursement->save();

        return redirect()->route('reimbursement');
    }
    
    public function reimbursementAction($status, $id) {
        $reimburse = Reimbursement::findOrFail($id);

        $reimburse->status = $status;
        $reimburse->save();
        
        return redirect()->route('reimbursement');
    }
    
    public function reimburseRevision(Request $request, $id) {
        $reimburse = Reimbursement::where('employee_id', $id)->firstOrFail();

        $reimburse->status = "Revision";
        $reimburse->reason_for_revision = $request->reason;
        $reimburse->save();
        
        return redirect()->route('reimbursement');
    }

    public function employeeDetail($id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();

        return view('employee.employeeDetail', ['emp' => $employee]);
    }

    public function employeeEmployment($id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();

        return view('employee.employeeEmployment', ['employee' => $employee]);
    }

    public function transferEmployee(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'newBranch' => 'required',
            'newPosition' => 'required',
            'newLevel' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $transfer= new Transfer();
        $transfer->employee_id = $id;
        $transfer->old_branch = $request->input('oldBranch');
        $transfer->new_branch = $request->input('newBranch');
        $transfer->old_position = $request->input('oldPosition');
        $transfer->new_position = $request->input('newPosition');
        $transfer->old_level = $request->input('oldLevel');
        $transfer->new_level = $request->input('newLevel');
        $transfer->date = date('Y-m-d');
        $transfer->save();
        $employee = Employee::findOrFail($id);
        $employee->branch = $request->input('newBranch');
        $employee->job_level = $request->input('newLevel');
        $employee->job_position = $request->input('newPosition');
        $employee->save();

        return redirect()->route('employee');
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
