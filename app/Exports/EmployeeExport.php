<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeExport implements FromView, ShouldAutoSize
{
    public function __construct(int $company_id)
    {
        $this->company_id = $company_id;
    }

    public function view(): View
    {
        $datas = DB::table('users')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('department_positions', 'employees.position_id', '=', 'department_positions.id')
            ->join('grades', 'employees.grade_id', '=', 'grades.id')
            ->where('users.company_id', $this->company_id)
            ->get();

        return view('export.excel_employee', [
            'employees' => $datas
        ]);
    }
}
