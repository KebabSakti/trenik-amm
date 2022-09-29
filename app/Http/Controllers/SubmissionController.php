<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Carbon\Carbon;
use App\Models\Submission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('submission.index');
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
        DB::transaction(function () use ($request) {
            $request->validate([
                'product_id' => 'bail|required',
                'credit_scheme_id' => 'bail|required',
                'foto' => 'bail|required',
                'permit' => 'bail|required',
                'consent' => 'bail|required',
                'phone' => 'required',
            ]);

            if (!$request->hasFile('foto') && !$request->hasFile('permit')) {
                return redirect()->back()->withErrors('Upload foto dan mine permit anda');
            }

            $submission = new Submission;
            $submission->user_id = Auth::user()->id;
            $submission->product_id = $request->product_id;
            $submission->credit_scheme_id = $request->credit_scheme_id;
            $submission->product_note = $request->product_note;
            $submission->phone = $request->phone;
            $submission->foto_ktp = $request->foto->store('attachment', 'custom');
            $submission->foto_permit = $request->permit->store('attachment', 'custom');
            $submission->save();
        });

        return redirect()->route('barang.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $credits = DB::table('credits')
            ->where('submission_id', $id)
            ->get();

        return view('submission.show', [
            'credits' => $credits
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
        //
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
        $col = [
            'products.product_name',
            '',
            'submissions.submission_status',
            'submissions.payment_status',
            'submissions.created_at',
            'submissions.updated_at',
        ];

        $query = DB::table('submissions')
            ->selectRaw('submissions.*, products.product_name')
            ->where('submissions.user_id', $request->user_id)
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('employees', 'employees.user_id', '=', 'users.id')
            ->join('products', 'submissions.product_id', '=', 'products.id');

        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->oRwhere('products.product_name', 'like', '%' . $request->search['value'] . '%');
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
            $schemes = DB::table('credit_schemes')->where('id', $r->credit_scheme_id)->first();

            if ($r->submission_status == 'pending') {
                $status = '<span class="badge rounded-pill text-bg-warning">PENDING</span>';
            }

            if ($r->submission_status == 'rejected') {
                $status = '<span class="badge rounded-pill text-bg-danger">REJECTED</span>';
            }

            if ($r->submission_status == 'approved') {
                $status = '<span class="badge rounded-pill text-bg-success">APPROVED</span>';
            }

            if ($r->payment_status == 'unpaid') {
                $payment = '<span class="badge rounded-pill text-bg-warning">UNPAID</span>';
            }

            if ($r->payment_status == 'progress') {
                $payment = '<span class="badge rounded-pill text-bg-info">PROGRESS</span>';
            }

            if ($r->payment_status == 'paid') {
                $payment = '<span class="badge rounded-pill text-bg-success">PAID</span>';
            }

            if ($r->payment_status == 'canceled') {
                $payment = '<span class="badge rounded-pill text-bg-danger">CANCELED</span>';
            }

            $data[] = [
                $r->product_name,
                'Cicilan : ' . $schemes->count . 'x
                <br>Harga : Rp ' . number_format($schemes->price, 2, ',', '.') . '
                <br>Bulanan : Rp ' . number_format($schemes->credit, 2, ',', '.'),
                $payment,
                $status,
                $r->status_note ?? '-',
                Carbon::parse($r->created_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString(),
                Carbon::parse($r->updated_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString(),
                ($r->submission_status != 'approved') ? '-' : '<a class="btn btn-info btn-sm" href="' . route('submission.show', $r->id) . '">Detail</a>',
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
