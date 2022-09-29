<?php

namespace App\Http\Controllers;

use App\Models\CreditScheme;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreditSchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('credit_scheme.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products =  Product::where('company_id', Auth::user()->company_id)
            ->where('active', 1)
            ->whereNotIn('id', function ($query) {
                $query->select('product_id')->from('credit_schemes');
            })
            ->orderBy('product_name', 'asc')
            ->get();

        return view('credit_scheme.create', ['products' => $products]);
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
            'product_id' => 'bail|required',
        ]);

        for ($i = 0; $i < count($request->counts); $i++) {
            DB::table('credit_schemes')->upsert(
                [
                    [
                        'product_id' => $request->product_id,
                        'count' => $request->counts[$i],
                        'price' => $request->prices[$i],
                        'credit' => $request->credits[$i],
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ]
                ],
                ['product_id'],
                [
                    'count',
                    'price',
                    'credit',
                    'updated_at',
                ]
            );
        }

        return redirect()->route('credit_scheme.index')->with('alert', 'Data berhasil di proses');
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
        $product = DB::table('products')
            ->where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->first();

        $credit = DB::table('credit_schemes')
            ->where('product_id', $id)
            ->get();

        return view('credit_scheme.edit', [
            'product' => $product,
            'credit' => $credit,
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
            'product_id' => 'bail|required',
        ]);

        for ($i = 0; $i < count($request->counts); $i++) {
            DB::table('credit_schemes')
                ->where('id', $request->ids[$i])
                ->update(
                    [
                        'count' => $request->counts[$i],
                        'price' => $request->prices[$i],
                        'credit' => $request->credits[$i],
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ],
                );
        }

        return redirect()->route('credit_scheme.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CreditScheme::where('product_id', $id)->delete();

        return redirect()->route('credit_scheme.index')->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
        $col = [
            'product_name',
        ];

        $query = Product::where('company_id', $request->company_id)
            ->whereIn('id', function ($q) {
                $q->select('product_id')->from('credit_schemes')->where('deleted_at', null);
            });

        if (!empty($request->search['value'])) {
            $query->where('product_name', 'like', '%' . $request->search['value'] . '%');
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
            // $scheme = DB::table('credit_schemes')->where('product_id', $r->id)->first();
            // $status = $scheme != null ? '<span class="badge rounded-pill text-bg-success">Aktif</span>' : '<span class="badge rounded-pill text-bg-danger">Non Aktif</span>';
            // $edit = $scheme != null ? '<a class="btn btn-info btn-sm" href="' . route('credit_scheme.edit', $r->id) . '">Edit</a>' : '-';

            $data[] = [
                $r->product_name,
                '<a class="btn btn-info btn-sm" href="' . route('credit_scheme.edit', $r->id) . '">Detail / Edit</a>
                <form method="post" action="' . route('credit_scheme.destroy', $r->id) . '" style="display:inline;">
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
