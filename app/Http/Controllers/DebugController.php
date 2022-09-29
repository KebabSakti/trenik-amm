<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebugController extends Controller
{
    public function index($param)
    {
        // $datas = DB::table('approval_rules')
        //     ->selectRaw('approval_rules.department_id as rule_dept_id, approval_rule_details.department_id as approval_dept_id, departments.department_name')
        //     ->join('approval_rule_details', 'approval_rule_details.approval_rule_id', '=', 'approval_rules.id')
        //     ->join('departments', 'approval_rule_details.department_id', '=', 'departments.id')
        //     ->where('approval_rules.department_id', $param)
        //     ->get();

        $user = DB::table('users')
            ->selectRaw('users.*, employees.department_id')
            ->leftJoin('employees', 'employees.user_id', '=', 'users.id')
            ->where('users.id', $param)
            ->first();

        $query = DB::table('submissions')
            ->selectRaw('submissions.*, users.role, employees.employee_name, employees.nik, employees.phone, departments.department_name, products.product_name')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->where('users.company_id', $user->company_id);

        if ($user->role == 'pic') {
            $query->whereIn('submissions.user_id',  function ($q) use ($user) {
                $q->select('users.id')
                    ->from('users')
                    ->join('employees', 'employees.user_id', '=', 'users.id')
                    ->join('approval_rules', 'employees.department_id', '=', 'approval_rules.department_id')
                    ->join('approval_rule_details', 'approval_rule_details.approval_rule_id', '=', 'approval_rules.id')
                    ->where('approval_rule_details.department_id', $user->department_id);
            });
        }

        $datas = $query->get();

        dd($datas);
    }
}
