<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRule;
use Illuminate\Http\Request;
use App\Models\ApprovalRuleDetail;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApprovalRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('rule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::whereNotIn('id', function ($q) {
            $q->select('department_id')->from('approval_rules');
        })
            ->where('company_id', Auth::user()->company_id)
            ->get();

        return view('rule.create', [
            'departments' => $departments
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
            'department_id' => 'bail|required',
        ]);

        if (!$request->department_ids) {
            return redirect()->route('rule.index')->withErrors('Anda belum menambahkan rule');
        }

        $rule = new ApprovalRule;
        $rule->company_id = $request->user()->company_id;
        $rule->department_id = $request->department_id;
        $rule->save();

        for ($i = 0; $i < count($request->department_ids); $i++) {
            $ruleDetail = new ApprovalRuleDetail();
            $ruleDetail->approval_rule_id = $rule->id;
            $ruleDetail->department_id = $request->department_ids[$i];
            $ruleDetail->approval_order = $i + 1;
            $ruleDetail->save();
        }

        return redirect()->route('rule.index')->with('alert', 'Data berhasil di proses');
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
        $rule = DB::table('approval_rules')
            ->selectRaw('approval_rules.*, departments.department_name')
            ->join('departments', 'approval_rules.department_id', '=', 'departments.id')
            ->where('approval_rules.company_id', Auth::user()->company_id)
            ->where('approval_rules.id', $id)
            ->first();

        $ruleDetails = DB::table('approval_rule_details')->where('approval_rule_id', $id)->get();

        $departments = Department::where('company_id', Auth::user()->company_id)->get();

        return view('rule.edit', [
            'rule' => $rule,
            'rule_details' => $ruleDetails,
            'departments' => $departments
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
        DB::table('approval_rules')
            ->where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->update([
                'updated_at' => now()->toDateTimeString(),
            ]);

        DB::table('approval_rule_details')->where('approval_rule_id', $id)->delete();

        for ($i = 0; $i < count($request->department_ids); $i++) {
            $ruleDetail = new ApprovalRuleDetail();
            $ruleDetail->approval_rule_id = $id;
            $ruleDetail->department_id = $request->department_ids[$i];
            $ruleDetail->approval_order = $i + 1;
            $ruleDetail->save();
        }

        return redirect()->route('rule.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('approval_rule_details')->where('approval_rule_id', $id)->delete();

        DB::table('approval_rules')
            ->where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->delete();

        return redirect()->route('rule.index')->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
        $col = ['description'];

        $query = ApprovalRule::selectRaw('approval_rules.*, departments.department_name')
            ->join('departments', 'approval_rules.department_id', '=', 'departments.id')
            ->where('approval_rules.company_id', $request->company_id)
            ->where('departments.deleted_at', null);

        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->where('description', 'like', '%' . $request->search['value'] . '%');
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
            $ruleDetails = DB::table('approval_rule_details')
                ->join('departments', 'approval_rule_details.department_id', '=', 'departments.id')
                ->where('approval_rule_id', $r->id)
                ->get();

            $depts = [];
            foreach ($ruleDetails as $ruleDetail) {
                array_push($depts, $ruleDetail->department_name);
            }

            $data[] = [
                $r->department_name,
                implode(' -> ', $depts),
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
