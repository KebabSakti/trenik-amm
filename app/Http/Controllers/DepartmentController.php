<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('department.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'bail|required',
        ]);

        DB::table('departments')->insert([
            'company_id' => $request->user()->company_id,
            'department_name' => $request->department_name,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return redirect()->back()->with('alert', 'Data berhasil di proses');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'bail:required',
            'department_name' => 'bail|required',
        ]);

        DB::table('departments')
            ->where('id', $request->id)
            ->update([
                'department_name' => $request->department_name,
                'updated_at' => now()->toDateTimeString(),
            ]);

        return redirect()->back()->with('alert', 'Data berhasil di proses');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'bail:required',
        ]);

        DB::table('departments')->where('id', $request->id)->delete();

        return redirect()->back()->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
    }
}
