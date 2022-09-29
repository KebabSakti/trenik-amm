<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WizardController extends Controller
{
    public function access()
    {
        return view('wizard.index');
    }

    public function add()
    {
        return view('wizard.add');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'access' => 'required'
        ]);

        if ($request->access == env('APP_WIZARD')) {
            $session = Str::uuid();

            session(['wizard_session' => $session]);

            return redirect('wizard/' . $session);
        }

        return redirect()->back()->withErrors("Kode akses yang anda masukkan salah");
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|unique:users',
            'password' => 'bail|required|min:6',
            'company_name' => 'bail|required',
            'phone' => 'bail|required',
            'monthly_balance' => 'bail|required|numeric|min:0',
        ]);

        $company = new Company();
        $company->company_name = $request->company_name;
        $company->monthly_balance = $request->monthly_balance;
        $company->phone = $request->phone;
        $company->save();

        $user = new User();
        $user->company_id = $company->id;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->active = 1;
        $user->save();

        return redirect('/')->with("alert", "Data berhasil ditambahkan");
    }
}
