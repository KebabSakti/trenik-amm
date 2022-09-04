<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PicApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('picapprove.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        DB::table('approvals')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'updated_at' => now()->toDateTimeString(),
            ]);

        return redirect()->route('picapprove.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function indexJSON(Request $request)
    {
        $col = ['employees.employee_name', 'departments.deparment_name', 'employees.nik', 'employees.phone', 'products.product_name', '', 'submissions.created_at', 'submissions.updated_at', ''];

        $department = DB::table('employees')->where('user_id', $request->user_id)->first();

        $query = DB::table('submissions')
            ->selectRaw('submissions.*, users.role, employees.employee_name, employees.nik, employees.phone, departments.department_name, products.product_name')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->whereIn('submissions.id', function ($q) use ($department) {
                $q->select('submission_id')->from('approvals')->where('department_id', $department->department_id);
            });

        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->oRwhere('employees.employee_name', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('departments.department_name', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('employees.nik', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('employees.phone', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('products.product_name', 'like', '%' . $request->search['value'] . '%');
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
            $approve = DB::table('approvals')->where('submission_id', $r->id)->where('department_id', $department->department_id)->first();

            if ($approve->status == 'pending') {
                $status = '<span class="badge rounded-pill text-bg-warning">Pending</span>';
            }

            if ($approve->status == 'rejected') {
                $status = '<span class="badge rounded-pill text-bg-danger">Rejected</span>';
            }

            if ($approve->status == 'approved') {
                $status = '<span class="badge rounded-pill text-bg-success">Approved</span>';
            }

            $data[] = [
                $r->employee_name,
                $r->department_name,
                $r->nik,
                $r->phone,
                $r->product_name,
                $status,
                Carbon::parse($r->created_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString(),
                Carbon::parse($r->updated_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString(),
                $approve->status != 'pending' ? '-' : '<form method="post" action="' . route('picapprove.update', $approve->id) . '" style="display:inline;">
                    <input type="hidden" name="_token" value="' . $request->csrf . '">
                    <input type="hidden" name="status" value="rejected">
                    ' . method_field('PUT') . '
                    <button type="submit" class="btn btn-danger btn-sm" href="#">Reject</button>
                 </form>
                 <form method="post" action="' . route('picapprove.update', $approve->id) . '" style="display:inline;">
                    <input type="hidden" name="_token" value="' . $request->csrf . '">
                    <input type="hidden" name="status" value="approved">
                    ' . method_field('PUT') . '
                    <button type="submit" class="btn btn-success btn-sm" href="#">Approve</button>
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
