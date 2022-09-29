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
        $submission = DB::table('submissions')
            ->selectRaw('submissions.*, credit_schemes.count, credit_schemes.price, credit_schemes.credit, employees.department_id, employees.employee_name, employees.nik, employees.ktp, products.product_name, department_positions.position_name, departments.department_name, users.company_id')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('department_positions', 'employees.position_id', '=', 'department_positions.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->join('credit_schemes', 'submissions.credit_scheme_id', '=', 'credit_schemes.id')
            ->where('submissions.id', $id)
            // ->where('submissions.submission_status', 'pending')
            ->first();

        if ($submission == null) {
            abort(404);
        }

        $products = DB::table('products')
            ->join('credit_schemes', 'credit_schemes.product_id', '=', 'products.id')
            ->where('products.active', 1)
            ->where('products.deleted_at', null)
            ->where('products.company_id', Auth::user()->company_id)
            ->where('credit_schemes.count', $submission->count)
            ->get();

        $mApproval = DB::table('approvals')->where('submission_id', $id);

        if (Auth::user()->role == 'pic') {
            $mApproval->where('status', '!=', 'reject');
        }

        $mApproval = $mApproval->first();

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

        $prcts = DB::table('products')
            ->where('company_id', Auth::user()->company_id)
            ->where('active', 1)
            ->where('deleted_at', null)
            ->whereIn('id', function ($q) {
                $q->select('product_id')->from('credit_schemes')->where('deleted_at', null);
            })
            ->get();

        foreach ($prcts as $prct) {
            $schemes = DB::table('credit_schemes')
                ->where('product_id', $prct->id)
                ->where('price', '<=', function ($q) use ($submission) {
                    $q->select('grades.max_credit')
                        ->from('grades')
                        ->join('employees', 'employees.grade_id', '=', 'grades.id')
                        ->where('employees.user_id', $submission->user_id);
                })
                ->get();

            $p[] = [
                'product_id' => $prct->id,
                'product_name' => $prct->product_name,
                'scheme' => $schemes,
            ];
        }

        return view('picapprove.show', [
            'submission' => $submission,
            'products' => $products,
            'mApproval' => $mApproval,
            'products' => $products,
            'prcts' => $p,
            'rules' => $a
        ]);
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
        $submission = DB::table('submissions')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('credit_schemes', 'submissions.credit_scheme_id', '=', 'credit_schemes.id')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->where('submissions.id', $id)
            ->first();

        if (Auth::user()->role == 'pic') {
            $approval = DB::table('approvals')
                ->where('submission_id', $id)
                ->where('department_id', Auth::user()->employee->department_id)
                ->first();

            if ($approval != null) {
                return redirect()->back();
            }

            DB::table('approvals')->insert([
                'submission_id' => $id,
                'user_id' => Auth::user()->id,
                'department_id' => Auth::user()->employee->department_id,
                'status' => $request->status,
                'note' => $request->note,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);

            if ($request->status == 'rejected') {
                DB::table('submissions')
                    ->where('id', $id)
                    ->update([
                        'submission_status' => 'rejected',
                        'payment_status' => 'canceled',
                        'status_note' => $request->note,
                        'updated_at' => now()->toDateTimeString(),
                    ]);

                return redirect()->route('picapprove.index')->with('alert', 'Data berhasil di proses');
            }

            $start_date = Carbon::now()->startOfYear()->toDateString();
            $end_date = Carbon::now()->endOfYear()->toDateString();

            $subs = DB::table('submissions')
                ->selectRaw('SUM(credit_schemes.price) as total_credit')
                ->join('credit_schemes', 'submissions.credit_scheme_id', '=', 'credit_schemes.id')
                ->join('users', 'submissions.user_id', '=', 'users.id')
                ->join('employees', 'employees.user_id', '=', 'users.id')
                ->where('users.company_id', $submission->company_id)
                ->where('submissions.submission_status', 'approved')
                ->whereDate('submissions.created_at', '>=', $start_date)
                ->whereDate('submissions.created_at', '<=', $end_date)
                ->first();

            $limit = $subs->total_credit + $submission->price;

            if ($submission->price > $limit) {
                DB::table('approvals')
                    ->where('submission_id', $id)
                    ->where('user_id', Auth::user()->id)
                    ->where('department_id', Auth::user()->employee->department_id)
                    ->delete();

                return redirect()->route('picapprove.index')->withErrors('Pengajuan melibihi batas limit koperasi per bulan');
            }

            $rules = DB::table('approval_rules')
                ->join('approval_rule_details', 'approval_rule_details.approval_rule_id', '=', 'approval_rules.id')
                ->where('approval_rules.department_id', $submission->department_id)
                ->get();

            $approvals = DB::table('approvals')
                ->where('submission_id', $id)
                ->where('status', 'approved')
                ->get();

            if (count($rules) == count($approvals)) {
                $now = now();

                DB::table('submissions')
                    ->where('id', $id)
                    ->update([
                        'submission_status' => 'approved',
                        'payment_status' => 'progress',
                        'updated_at' => $now->toDateTimeString(),
                    ]);

                for ($i = 1; $i <= $submission->count; $i++) {
                    $billed = $now->addMonth()->startOfMonth()->toDateString();

                    DB::table('credits')->insert([
                        'submission_id' => $id,
                        'month' => $i,
                        'amount' => $submission->credit,
                        'billed_at' => $billed,
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ]);
                }

                return redirect()->route('picapprove.index')->with('alert', 'Data berhasil di proses');
            }
        }

        if (Auth::user()->role == 'admin') {
            DB::table('submissions')
                ->where('id', $id)
                ->update([
                    'product_id' => $request->product_id,
                    'credit_scheme_id' => $request->credit_scheme_id,
                    'updated_at' => now()->toDateTimeString(),
                ]);
        }

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

        $start_date = Carbon::create($request->start_date)->toDateString();
        $end_date = Carbon::create($request->end_date)->toDateString();

        $user = DB::table('users')
            ->selectRaw('users.*, employees.department_id')
            ->leftJoin('employees', 'employees.user_id', '=', 'users.id')
            ->where('users.id', $request->user_id)
            ->first();

        $query = DB::table('submissions')
            ->selectRaw('submissions.*, users.role, employees.employee_name, employees.nik, employees.phone, departments.department_name, products.product_name')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('products', 'submissions.product_id', '=', 'products.id')
            ->where('users.company_id', $user->company_id)
            ->whereIn('submissions.user_id',  function ($q) use ($user) {
                $q->select('users.id')
                    ->from('users')
                    ->join('employees', 'employees.user_id', '=', 'users.id')
                    ->join('approval_rules', 'employees.department_id', '=', 'approval_rules.department_id')
                    ->join('approval_rule_details', 'approval_rule_details.approval_rule_id', '=', 'approval_rules.id');

                if ($user->role == 'pic') {
                    $q->where('approval_rule_details.department_id', $user->department_id);
                }
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

        $query = $query->whereDate('submissions.created_at', '>=', $start_date)
            ->whereDate('submissions.created_at', '<=', $end_date);

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
            if ($r->submission_status == 'pending') {
                $status = '<span class="badge rounded-pill text-bg-warning">PENDING</span>';
            }

            if ($r->submission_status == 'rejected') {
                $status = '<span class="badge rounded-pill text-bg-danger">REJECTED</span>';
            }

            if ($r->submission_status == 'approved') {
                $status = '<span class="badge rounded-pill text-bg-success">APPROVED</span>';
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
                '<a class="btn btn-primary btn-sm" href="' . route('picapprove.show', $r->id) . '">Detail</a>
                <a href="' . route('submission_detail', $r->id) . '" class="btn btn-sm btn-info" target="_blank">Export PDF</a>',
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
