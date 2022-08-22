<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalRuleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rule.create');
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
            'approval_rule_id' => 'bail|required',
            'department_id' => 'bail|required',
            'approval_order' => 'bail|required',
        ]);

        DB::table('approval_rule_details')->insert([
            'approval_rule_id' => $request->approval_rule_id,
            'department_id' => $request->department_id,
            'approval_order' => $request->approval_order,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return redirect()->route('setting.index')->with('alert', 'Data berhasil di proses');
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
        $model = DB::table('approval_rule_details')->where('id', $id)->first();

        return view('rule_detail.edit', ['model' => $model]);
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
            'approval_rule_id' => 'bail|required',
            'department_id' => 'bail|required',
            'approval_order' => 'bail|required',
        ]);

        DB::table('approval_rule_details')
            ->where('id', $id)
            ->update([
                'department_id' => $request->department_id,
                'approval_order' => $request->approval_order,
                'updated_at' => now()->toDateTimeString(),
            ]);

        return redirect()->route('setting.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('approval_rule_details')->where('id', $id)->delete();

        return redirect()->route('setting.index')->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
        $col = ['', '', ''];

        $query = DB::table('approval_rule_details')
            ->join('approval_rules', 'approval_rule_details.id', '=', 'approval_rules.id')
            ->join('departments', 'approval_rule_details.id', '=', 'department.id');

        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->where('rule_name', 'like', '%' . $request->search['value'] . '%');
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
            $data[] = [
                $r->rule_name,
                '<a class="btn btn-info btn-sm" href="' . route('rule.edit', $r->id) . '">Edit</a>
                 <form method="post" action="' . route('rule.destroy', $r->id) . '" style="display:inline;">
                    <input type="hidden" name="_token" value="' . $request->csrf . '">
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" href="#">Hapus</button>
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
