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
use App\Models\Employee;
use App\Models\Reimbursement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function loginProcess(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $admin = Admin::where('username', $credentials['username'])->first();

        if ($admin && $credentials['password'] == $admin->password) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors('Invalid credentials');
        }
    }

    public function logoutProcess()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }

    public function employee()
    {
        $employee = Employee::all();

        return view('backend.employee.employee', ['employee' => $employee]);
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
            'tunjangan' => 'required|numeric'
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
        $employee->tunjangan = $request->input('tunjangan');

        $employee->save();

        return redirect()->route('dashboard');
    }

    public function editEmployee(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'organization' => 'required',
            'email' => 'required|unique:employees,email,' . $id . ',id',
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

    public function employeeDetail($id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();
        $url = Storage::url('app/') . $employee->photo;
        return view('backend.employee.employeeDetail', ['emp' => $employee, 'url' => $url]);
    }

    public function employeeEmployment($id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();

        return view('backend.employee.employeeEmployment', ['emp' => $employee]);
    }

    public function employeeTransferLog($id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();
        $transfer_log = Transfer::where('employee_id', $id)->get();
        return view('backend.employee.employeeTransferLog', ['emp' => $employee, 'transferData' => $transfer_log]);
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

        $transfer = new Transfer();
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

    public function changeProfilePic(Request $request, $id) 
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $employee = Employee::findOrFail($id);
        
        $employee->photo = file_get_contents($request->image);
        $employee->save();
        return redirect()->route('employee');
    }

    public function resign($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->resign_date = date('Y-m-d');
        $employee->save();
        return redirect()->route('employee');
    }

    public function attendance()
    {
        $attendanceData = [];
        $present = 0;
        $absent = 0;
        $timeoff = 0;
        $attendance = Attendance::orderBy('attendance_id', 'desc')->get();

        $processedEmployeeIds = [];
        foreach ($attendance as $attendance) {

            if (in_array($attendance->employee_id, $processedEmployeeIds)) {
                break;
            }
            $toff = Timeoff::where('employee_id', $attendance->employee_id)->first();
            $emp = Employee::where('id', $attendance->employee_id)->firstOrFail();
            $overtime = Overtime::where('employee_id', $attendance->employee_id)->first();
            $attendanceData[] = [
                'attendance_id' => $attendance->attendance_id,
                'employee_id' => $attendance->employee_id,
                'employee_name' => $emp->name,
                'timeoff_id' => $toff && $toff->status === "Accept" ? $toff->timeoff_id : null,
                'date' => $attendance->date,
                'schedule_in' => $attendance->schedule_in,
                'schedule_out' => $attendance->schedule_out,
                'clock_in' => $attendance->clock_in,
                'clock_out' => $attendance->clock_out,
                'overtime_id' => $overtime && $overtime->status === "Accept" ? $overtime->overtime_id : null
            ];
            if ($attendance->clock_in) $present++;
            else if ($attendanceData[count($attendanceData) - 1]['timeoff_id']) $timeoff++;
            else $absent++;
            $processedEmployeeIds[] = $attendance->employee_id;
        }

        return view('backend.timeManagement.attendance', ['attendance' => $attendanceData, 'present' => $present, 'absent' => $absent, 'timeoff' => $timeoff]);
    }

    public function generateAttendance()
    {
        $cacheKey = 'attendance_' . now()->format('Y-m-d');
        if (Cache::has($cacheKey)) {
            return redirect()->route('attendance')
                ->withErrors(['message' => 'Today employee attendance already downloaded.']);;
        }
        $employee = Employee::all();
        $today = Carbon::parse(Carbon::now());

        foreach ($employee as $employee) {
            $attendance = new Attendance();
            $attendance->employee_id = $employee->id;
            $attendance->schedule_in = "08:00:00";
            $attendance->schedule_out = "18:00:00";
            $attendance->date = $today;
            $attendance->save();
        }
        Cache::put($cacheKey, now()->endOfDay());

        return redirect()->route('attendance');
    }

    public function attendanceEdit($attendance_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_in' => 'required',
            'schedule_out' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $attendance = Attendance::findOrFail($attendance_id);
        $attendance->schedule_in = $request->input('schedule_in');
        $attendance->schedule_out = $request->input('schedule_out');
        $attendance->save();

        return redirect()->route('attendance');
    }

    public function calendar()
    {
        $events = Event::all();
        $eventData = [];
        foreach ($events as $evt) {
            $eventData[] = [
                'title' => $evt->title,
                'start_date' => $evt->start_date,
                'end_date' => $evt->end_date,
                'id'=>$evt->id
            ];
        }
        return view('backend.timeManagement.calendar', ['events' => $eventData]);
    }

    public function addEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $event = new Event();
        $event->start_date = $request->input('start_date');
        $event->title = $request->input('title');
        $event->end_date = ($request->input('end_date')) ? $request->input('end_date') : null;
        $event->save();
        return redirect()->route('calendar');
    }

    public function deleteEvent($event_id)
    {
        $event = Event::findOrFail($event_id);
        $event->delete();

        return redirect()->route('calendar');
    }

    public function editEvent($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_title' => 'required',
            'new_start_date' => 'required|date',
            'new_end_date' => 'nullable|date'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $event = Event::findOrFail($id);
        $event->start_date = $request->input('new_start_date');
        $event->title = $request->input('new_title');
        $event->end_date = ($request->input('new_end_date')) ? $request->input('new_end_date') : null;
        $event->save();
        return redirect()->route('calendar');
    }
    public function overtime()
    {
        $overtime = Overtime::all();
        $overtimeData = [];
        foreach ($overtime as $ovt) {
            $emp = Employee::where('id', $ovt->employee_id)->first();
            $overtimeData[] = [
                'employee_id' => $ovt->employee_id,
                'overtime_id' => $ovt->overtime_id,
                'overtime_date' => $ovt->overtime_date,
                'duration' => $ovt->duration,
                'file' => $ovt->file,
                'description' => $ovt->description,
                'status' => $ovt->status,
                'employee_name' => $emp->name
            ];
        }
        return view('backend.timeManagement.overtime', ['overtime' => $overtimeData]);
    }

    public function overtimeAssign(Request $request)
    {
        $overtime = new Overtime();
        $attendance = Attendance::where('employee_id', $request->employee_id)->first();
        $overtime->employee_id = $request->employee_id;
        $overtime->overtime_date = $request->scheduleDate;
        $scheduleOut = Carbon::parse($attendance->schedule_out);
        $newTime = $scheduleOut->addSeconds($request->scheduleTime * 3600)->format('H:i:s');
        $overtime->duration = $newTime;
        $overtime->description = $request->description;
        $overtime->status = "Pending";
        $overtime->save();

        return redirect()->route('overtime');
    }

    public function overtimeStatusChange($status, $id)
    {
        $overtime = Overtime::findOrFail($id);

        $overtime->status = $status;
        $overtime->save();

        return redirect()->route('overtime');
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

    public function scheduler()
    {
        $scheduler = Scheduler::all();
        $schedulerData = [];
        $employee = Employee::all();

        foreach ($scheduler as $sched) {
            $emp = Employee::where('id', $sched->employee_id)->first();

            $schedulerData[] = [
                'name' => $emp->name,
                'branch' => $emp->branch,
                'organization' => $emp->organization,
                'job_position' => $emp->job_position,
                'employee_id' => $sched ? $sched->employee_id : null,
                'scheduler_id' => $sched ? $sched->scheduler_id : null,
                'current_schedule' => $sched ? Carbon::parse($sched->current_schedule)->format('j F, Y') : null,
                'schedule_time' => $sched ? Carbon::parse($sched->schedule_time)->format('h:i A') : null,
                'schedule_description' => $sched ? $sched->schedule_detail : null,
            ];
        }

        return view('backend.timeManagement.scheduler', ['employee' => $employee, 'scheduler' => $schedulerData]);
    }

    public function assignScheduler(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scheduleDate' => 'required',
            'scheduleTime' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $scheduler = new Scheduler();
        $scheduler->employee_id = $request->employee_id;
        $scheduler->current_schedule = $request->scheduleDate;
        $scheduler->schedule_time = $request->scheduleTime;
        $scheduler->schedule_detail = $request->description;
        $scheduler->save();

        return redirect()->route('scheduler');
    }

    public function editScheduler(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'scheduleDate' => 'required',
            'scheduleTime' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $scheduler = Scheduler::findOrFail($id);
        $scheduler->employee_id = $request->employee_id;
        $scheduler->current_schedule = $request->scheduleDate;
        $scheduler->schedule_time = $request->scheduleTime;
        $scheduler->schedule_detail = $request->description;
        $scheduler->save();

        return redirect()->route('scheduler');
    }

    public function timeoff()
    {
        $timeoff = Timeoff::all();
        $timeoffData = [];

        foreach ($timeoff as $timeoff) {
            $emp = Employee::where('id', $timeoff->employee_id)->firstOrFail();

            $timeoffData[] = [
                'timeoff_id' => $timeoff->timeoff_id,
                'id' => $timeoff->employee_id,
                'employee_name' => $emp->name,
                'effective_date' => $timeoff->effective_date,
                'expiration_date' => $timeoff->expiration_date,
                'status' => $timeoff->status
            ];
        }

        return view('backend.timeManagement.timeoff', ['timeoff' => $timeoffData]);
    }

    public function statusChange($status, $id)
    {
        $timeoff = Timeoff::findOrFail($id);
        $timeoff->status = $status;
        $timeoff->save();

        return redirect()->route('timeoff');
    }

    public function announcement()
    {
        $announcements = Announcement::all();

        return view('backend.announcement', ['announcements' => $announcements]);
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

    public function editannouncement(Request $request, $id)
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

    public function deleteannouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('announcement');
    }

    public function payroll()
    {
        $employee = Employee::all();
        $employeeData = [];
        foreach ($employee as $emp) {
            $overtime = Overtime::where('employee_id', $emp->id)->get();
            $scheduleOut = Carbon::parse('18:00:00')->format('H');
            $interval = NULL;
            foreach ($overtime as $ovt) {
                if ($ovt->status == "Accept") {
                    $interval += (Carbon::parse($ovt->duration)->format('H')) - $scheduleOut;
                }
            }
            $employeeData[] = [
                'id' => $emp->id,
                'name' => $emp->name,
                'salary' => $emp->salary,
                'resign_date' => $emp->resign_date,
                'tunjangan' => $emp->tunjangan,
            ];

            if ($interval !== NULL) {
                $employeeData[count($employeeData) - 1]['overtime_duration'] = $interval;
            }
        }

        return view('backend.payroll', ['employee' => $employeeData]);
    }

    public function payrollEdit(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'newSalary' => 'required',
            'newTunjanganJabatan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $employee = Employee::where('id', $id)->firstOrFail();
        $employee->salary = $request->newSalary;
        $employee->tunjangan = $request->newTunjanganJabatan;
        $employee->save();

        return redirect()->route('payroll');
    }

    public function reimbursement()
    {
        $reimbursement = Reimbursement::all();
        $reimbursementData = [];

        foreach ($reimbursement as $reimbursement) {
            $emp = Employee::where('id', $reimbursement->employee_id)->firstOrFail();

            $reimbursementData[] = [
                'name' => $emp->name,
                'id' => $reimbursement->reimburse_id,
                'employee_id' => $reimbursement->employee_id,
                'reimbursement_type' => $reimbursement->reimbursement_type,
                'total_reimbursement' => $reimbursement->total_reimbursement,
                'status' => $reimbursement->status,
                'proof' =>$reimbursement->proof
            ];
        }

        return view('backend.reimbursement', ['reimbursement' => $reimbursementData]);
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

    public function reimbursementAction($status, $id)
    {
        $reimburse = Reimbursement::findOrFail($id);

        $reimburse->status = $status;
        $reimburse->save();

        return redirect()->route('reimbursement');
    }

    public function reimburseRevision(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $reimburse = Reimbursement::where('reimburse_id', $id)->firstOrFail();

        $reimburse->status = "Revision";
        $reimburse->reason_for_revision = $request->reason;
        $reimburse->save();

        return redirect()->route('reimbursement');
    }

}
