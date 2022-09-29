<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubmissionRecap implements FromView, ShouldAutoSize
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $start_date = Carbon::create($this->request->start_date_list_pengajuan)->toDateString();
        $end_date = Carbon::create($this->request->end_date_list_pengajuan)->toDateString();

        $submissions = DB::table('submissions')
            ->selectRaw('submissions.*, credit_schemes.count, credit_schemes.price, credit_schemes.credit, employees.department_id, employees.employee_name, employees.nik, employees.ktp, products.product_name, department_positions.position_name, departments.department_name, users.company_id')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('department_positions', 'employees.position_id', '=', 'department_positions.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->join('credit_schemes', 'submissions.credit_scheme_id', '=', 'credit_schemes.id')
            ->where('users.company_id', $this->request->user()->company_id)
            ->whereDate('submissions.created_at', '>=', $start_date)
            ->whereDate('submissions.created_at', '<=', $end_date)
            ->get();

        $company = DB::table('companies')->where('id', $this->request->user()->company_id)->first();

        return view('export.excel_submission_recap', [
            'submissions' => $submissions,
            'company' => $company
        ]);
    }
}
