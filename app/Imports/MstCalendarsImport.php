<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\MstCalender;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithValidation;

class MstCalendarsImport implements ToModel, WithHeadingRow, WithStartRow, WithCustomCsvSettings, WithValidation
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new MstCalender([
            'year'  => $row['year'],
            'month' => $row['month'],
            'working_days' => $row['working_days'],
        ]);
    }

    /**
     *
     * @return validation rules array
     */
    public function rules(): array
    {
        return [
            'year' => 'required|max:4',
            'month' => 'required|max:2',
            'working_days' => 'required|max:2',
        ];
    }
}
