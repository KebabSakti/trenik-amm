<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class Layout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $submissions = DB::table('submissions')
            ->selectRaw('submissions.*, users.role, employees.employee_name, employees.nik, employees.phone, departments.department_name, products.product_name')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->whereIn('submissions.id', function ($q) {
                $q->select('submission_id')
                    ->from('approvals')
                    ->where('status', 'pending')
                    ->where('department_id', Auth::user()->employee->department_id ?? '');
            })->get();

        return view('components.layout', ['submissions' => $submissions]);
    }
}
