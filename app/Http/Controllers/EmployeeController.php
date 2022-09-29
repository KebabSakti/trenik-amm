<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentPosition;
use App\Models\Employee;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('company_id', Auth::user()->company_id)->get();

        $positions = DepartmentPosition::where('company_id', Auth::user()->company_id)->get();

        $grades = Grade::where('company_id', Auth::user()->company_id)->get();

        return view('employee.create', [
            'departments' => $departments,
            'positions' => $positions,
            'grades' => $grades
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|unique:users',
            'employee_name' => 'bail|required',
            'nik' => 'bail|required|unique:employees',
            'ktp' => 'bail|required|unique:employees',
            'phone' => 'bail|required|numeric|unique:employees',
            'department_id' => 'bail|required',
            'position_id' => 'bail|required',
            'grade_id' => 'bail|required',
            'role' => 'bail|required',
        ]);

        $user = new User;
        $user->company_id = Auth::user()->company_id;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->active = $request->active == true ? 1 : 0;
        $user->password = Hash::make($request->nik);
        $user->save();

        $employee = new Employee;
        $employee->user_id = $user->id;
        $employee->department_id = $request->department_id;
        $employee->position_id = $request->position_id;
        $employee->grade_id = $request->grade_id;
        $employee->employee_name = $request->employee_name;
        $employee->nik = $request->nik;
        $employee->ktp = $request->ktp;
        $employee->phone = $request->phone;
        $employee->save();

        return redirect()->route('employee.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = DB::table('users')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->where('users.company_id', Auth::user()->company_id)
            ->where('users.id', $id)
            ->first();

        $departments = Department::where('company_id', Auth::user()->company_id)->get();

        $positions = DepartmentPosition::where('company_id', Auth::user()->company_id)->get();

        $grades = Grade::where('company_id', Auth::user()->company_id)->get();

        return view('employee.edit', [
            'departments' => $departments,
            'positions' => $positions,
            'grades' => $grades,
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_name' => 'bail|required',
            'nik' => 'bail|required',
            'ktp' => 'bail|required',
            'phone' => 'bail|required|numeric',
            'department_id' => 'bail|required',
            'position_id' => 'bail|required',
            'grade_id' => 'bail|required',
            'role' => 'bail|required',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->active = $request->active == true ? 1 : 0;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $employee = Employee::where('user_id', $id)->firstOrFail();
        $employee->department_id = $request->department_id;
        $employee->position_id = $request->position_id;
        $employee->grade_id = $request->grade_id;
        $employee->employee_name = $request->employee_name;
        $employee->nik = $request->nik;
        $employee->ktp = $request->ktp;
        $employee->phone = $request->phone;
        $employee->save();

        return redirect()->route('employee.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        Employee::where('user_id', $id)->delete();

        return redirect()->route('employee.index')->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
        $col = [
            'users.email',
            'employees.employee_name',
            'employees.nik',
            'employees.ktp',
            'employees.phone',
            'departments.department_name',
            'department_positions.position_name',
            'grades.grade_name',
            'users.role',
            'users.active'
        ];

        $query = User::join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('department_positions', 'employees.position_id', '=', 'department_positions.id')
            ->join('grades', 'employees.grade_id', '=', 'grades.id')
            ->where('users.company_id', $request->company_id);


        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->oRwhere('users.email', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('employees.employee_name', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('employees.nik', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('employees.ktp', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('employees.phone', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('departments.department_name', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('department_positions.position_name', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('grades.grade_name', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('users.role', 'like', '%' . $request->search['value'] . '%');
            });
        }

        //total record
        $total = $query->get()->count();

        $table = $query->orderBy($col[$request->order[0]['column']], $request->order[0]['dir'])
            ->offset($request->start)
            ->limit($total)
            ->get();

        //total record with search value
        $filter = (!empty($request->search['value'])) ?
            $table->count()
            :
            $total;

        $data = [];
        foreach ($table as $r) {
            $status = $r->active == 1 ? '<span class="badge rounded-pill text-bg-success">Aktif</span>' : '<span class="badge rounded-pill text-bg-danger">Non Aktif</span>';

            $data[] = [
                $r->email,
                $r->employee_name,
                $r->nik,
                $r->ktp,
                $r->phone,
                $r->department_name,
                $r->position_name,
                $r->grade_name . ' (Rp.' . number_format($r->max_credit, 2, ',', '.') . ')',
                '<span class="badge rounded-pill text-bg-primary">' . Str::upper($r->role) . '</span>',
                $status,
                '<a class="btn btn-info btn-sm" href="' . route('employee.edit', $r->user_id) . '">Edit</a>
                 <form method="post" action="' . route('employee.destroy', $r->user_id) . '" style="display:inline;">
                    <input type="hidden" name="_token" value="' . $request->csrf . '">
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm confirm">Hapus</button>
                 </form>',
            ];
        }

        return response()->json([
            'draw' => (int)$request->draw++,
            'recordsTotal' => $total,
            'recordsFiltered' => $filter,
            'data' => $data
        ]);
    }
}
