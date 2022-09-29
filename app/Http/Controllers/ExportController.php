<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Exports\SubmissionRecap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function submission_detail($id)
    {
        $submission = DB::table('submissions')
            ->selectRaw('submissions.*, credit_schemes.count, credit_schemes.price, credit_schemes.credit, employees.department_id, employees.employee_name, employees.nik, employees.ktp, products.product_name, department_positions.position_name, departments.department_name, users.company_id, companies.company_name')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('department_positions', 'employees.position_id', '=', 'department_positions.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->join('credit_schemes', 'submissions.credit_scheme_id', '=', 'credit_schemes.id')
            ->where('submissions.id', $id)
            ->first();

        $rules = DB::table('approval_rules')
            ->selectRaw('approval_rule_details.*, departments.department_name')
            ->join('approval_rule_details', 'approval_rule_details.approval_rule_id', '=', 'approval_rules.id')
            ->join('departments', 'approval_rule_details.department_id', '=', 'departments.id')
            ->where('approval_rules.department_id', $submission->department_id)
            ->get();

        foreach ($rules as $rule) {
            $b = DB::table('approvals')
                ->selectRaw('approvals.*, employees.employee_name')
                ->join('users', 'approvals.user_id', '=', 'users.id')
                ->join('employees', 'employees.user_id', '=', 'users.id')
                ->where('approvals.submission_id', $id)
                ->where('approvals.department_id', $rule->department_id)
                ->first();

            if ($b == null) {
                $a[] = [
                    'status' => 'pending',
                    'department_name' => $rule->department_name,
                    'user_id' => null,
                    'employee_name' => null,
                    'updated_at' => $submission->updated_at
                ];
            } else {
                $a[] = [
                    'status' => $b->status,
                    'department_name' => $rule->department_name,
                    'user_id' => $b->user_id,
                    'employee_name' => $b->employee_name,
                    'updated_at' => $b->updated_at
                ];
            }
        }

        $file = 'Detail Pengajuan ' . $submission->employee_name . '.pdf';

        $pdf = Pdf::loadView('export.submission_detail', [
            'submission' => $submission,
            'approvals' => $a,
        ])->stream($file);

        return $pdf;
    }

    public function submission_recap(Request $request)
    {
        $start_date = Carbon::create($request->start_date_list_pengajuan)->toDateString();
        $end_date = Carbon::create($request->end_date_list_pengajuan)->toDateString();

        $submissions = DB::table('submissions')
            ->selectRaw('submissions.*, credit_schemes.count, credit_schemes.price, credit_schemes.credit, employees.department_id, employees.employee_name, employees.nik, employees.ktp, products.product_name, department_positions.position_name, departments.department_name, users.company_id')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('department_positions', 'employees.position_id', '=', 'department_positions.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->join('credit_schemes', 'submissions.credit_scheme_id', '=', 'credit_schemes.id')
            ->where('users.company_id', Auth::user()->company_id)
            ->whereDate('submissions.created_at', '>=', $start_date)
            ->whereDate('submissions.created_at', '<=', $end_date)
            ->get();

        $company = DB::table('companies')->where('id', Auth::user()->company_id)->first();

        $file = 'Rekap Pengajuan Karyawan ' . $start_date . ' ' . $end_date . '.pdf';

        $pdf = Pdf::setPaper('a4', 'landscape')
            ->loadView('export.submission_recap', [
                'submissions' => $submissions,
                'company' => $company,
            ])->stream($file);

        return $pdf;
    }

    public function pdf_employee()
    {
        $datas = DB::table('users')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('department_positions', 'employees.position_id', '=', 'department_positions.id')
            ->join('grades', 'employees.grade_id', '=', 'grades.id')
            ->where('users.company_id', Auth::user()->company_id)
            ->get();

        $file =  'Export Karyawan ' . Carbon::now('UTC')->timezone('Asia/Kuala_Lumpur')->toDateString() . '.pdf';

        $pdf = Pdf::setPaper('a4', 'landscape')
            ->loadView('export.pdf_employee', [
                'employees' => $datas,
            ])->stream($file);

        return $pdf;
    }

    public function excel_employee()
    {
        $file =  'Export Karyawan ' . Carbon::now('UTC')->timezone('Asia/Kuala_Lumpur')->toDateString() . '.xlsx';

        return Excel::download(new EmployeeExport(Auth::user()->company_id), $file);
    }

    public function excel_submission_recap(Request $request)
    {
        $file =  'Rekap Pengajuan Karyawan ' . Carbon::now('UTC')->timezone('Asia/Kuala_Lumpur')->toDateString() . '.xlsx';

        return Excel::download(new SubmissionRecap($request), $file);
    }
}
