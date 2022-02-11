<?php

namespace App\Console\Commands;

use App\Contracts\Dao\Attendance\AttendanceDaoInterface;
use Illuminate\Console\Command;
use App\Exports\AttendanceExport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceBackup extends Command
{
    /**
     * attendance dao
     */
    private $attendanceDao;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendances:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store Backup info of attendances monthy before deleting records in database';

    /**
     * Create a new command instance.
     *
     * @param AttendanceDaoInterface
     * @return void
     */
    public function __construct(AttendanceDaoInterface $attendanceDao)
    {
        parent::__construct();

        $this->attendanceDao = $attendanceDao;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filePath = 'attendance' . config('path.separator') . Carbon::now()->month . '_'
            . Carbon::now()->year . config('path.separator') . 'attendances.xlsx';
        $downloader = app()->make(AttendanceExport::class);
        ($downloader)->store($filePath);

        if (!$this->attendanceDao->deleteMonthlyAttendances()) {
            Log::error('DB backup error', ['errors' => 'Some DB deleting errors.']);
        }
    }
}
