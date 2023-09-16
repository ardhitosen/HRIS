<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Console\Command;

class GenerateAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employee = Employee::all();
        $today = Carbon::now()->format('Y-m-d');
        
    foreach ($employee as $employee) {
        $attendance = new Attendance();
        $attendance->employee_id = $employee->id;
        $attendance->schedule_in = "08:00:00";
        $attendance->schedule_out = "18:00:00";
        $attendance->date = $today;
        $attendance->save();
    }
    }
}
