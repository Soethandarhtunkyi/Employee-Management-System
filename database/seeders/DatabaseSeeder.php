<?php

namespace Database\Seeders;

use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Departments dummy
        $departments = ['Production', 'Research and Development', 'Human Resource Management'];
        foreach ($departments as $department) {
            DB::table('mst_departments')->insert([
                'name' => $department
            ]);
        }

        // Roles dummy
        $roles= ['Manager', 'Senior', 'Junior'];
        foreach ($roles as $role) {
            DB::table('mst_roles')->insert([
                'name' => $role
            ]);
        }

        // Calenders dummy
        $working_days = [18, 19, 20, 21, 22];
        for ($i = 1; $i <= 12; $i++) {
            DB::table('mst_calenders')->insert([
                'year' => 2022,
                'month' => $i,
                'working_days' => Arr::random($working_days)
            ]);
        }

        \App\Models\Employee::factory(10)->create();

        // Salaries and Attendances dummy
        $employees = \App\Models\Employee::all();
        foreach ($employees as $employee) {
            $employee->salary()->create([
                'leave_fine' => 10000,
                'overtime_fee' => 10000,
                'basic_salary' => 500000
            ]);

            $begin = Carbon::create(2022, 1, 1, 8, 0, 0, 'Asia/Yangon');
            $end = Carbon::create(2022, 1, 18, 8, 0, 0, 'Asia/Yangon');
            $period = CarbonPeriod::create($begin, $end);
            foreach ($period as $date) {
                $employee->attendances()->create([
                    'working_hours' => 9,
                    'type' => rand(0, 1),
                    'overtime' => 1,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }
        }
    }
}
