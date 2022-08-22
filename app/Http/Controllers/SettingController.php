<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.create');
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
            'setting_name' => 'bail|required',
            'max_credit' => 'bail|required|min:0',
        ]);

        DB::table('settings')->insert([
            'company_id' => $request->user()->company_id,
            'setting_name' => $request->setting_name,
            'max_credit' => $request->max_credit,
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
        $model = DB::table('settings')->where('id', $id)->first();

        return view('setting.edit', ['model' => $model]);
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
            'setting_name' => 'bail|required',
            'max_credit' => 'bail|required|min:0',
        ]);

        DB::table('settings')
            ->where('id', $id)
            ->update([
                'setting_name' => $request->setting_name,
                'max_credit' => $request->max_credit,
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
        DB::table('settings')->where('id', $id)->delete();

        return redirect()->route('setting.index')->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
        $col = ['setting_name', 'max_credit'];

        $query = DB::table('settings');

        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->where('setting_name', 'like', '%' . $request->search['value'] . '%');
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
                $r->setting_name,
                $r->max_credit,
                '<a class="btn btn-info btn-sm" href="' . route('setting.edit', $r->id) . '">Edit</a>
                 <form method="post" action="' . route('setting.destroy', $r->id) . '" style="display:inline;">
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
