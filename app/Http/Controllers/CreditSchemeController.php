<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $products = $this->products();

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
            'price_1x' => 'bail|required|min:0',
            'credit_1x' => 'bail|required|min:0',
            'price_3x' => 'bail|required|min:0',
            'credit_3x' => 'bail|required|min:0',
            'price_6x' => 'bail|required|min:0',
            'credit_6x' => 'bail|required|min:0',
            'price_9x' => 'bail|required|min:0',
            'credit_9x' => 'bail|required|min:0',
            'price_12x' => 'bail|required|min:0',
            'credit_12x' => 'bail|required|min:0',
        ]);

        DB::table('credit_schemes')->upsert(
            [
                [
                    'product_id' => $request->product_id,
                    'price_1x' => $request->price_1x,
                    'credit_1x' => $request->credit_1x,
                    'price_3x' => $request->price_3x,
                    'credit_3x' => $request->credit_3x,
                    'price_6x' => $request->price_6x,
                    'credit_6x' => $request->credit_6x,
                    'price_9x' => $request->price_9x,
                    'credit_9x' => $request->credit_9x,
                    'price_12x' => $request->price_12x,
                    'credit_12x' => $request->credit_12x,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]
            ],
            [
                'product_id',
                'price_1x',
                'credit_1x',
                'price_3x',
                'credit_3x',
                'price_6x',
                'credit_6x',
                'price_9x',
                'credit_9x',
                'price_12x',
                'credit_12x',
            ]
        );

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
        $credit = DB::table('credit_schemes')
            ->select('credit_schemes.*', 'credit_schemes.id as scheme_id', 'products.product_name', 'products.id as product_id')
            ->join('products', 'credit_schemes.product_id', '=', 'products.id')
            ->where('credit_schemes.id', $id)
            ->first();

        return view('credit_scheme.edit', [
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
            'price_1x' => 'bail|required|min:0',
            'credit_1x' => 'bail|required|min:0',
            'price_3x' => 'bail|required|min:0',
            'credit_3x' => 'bail|required|min:0',
            'price_6x' => 'bail|required|min:0',
            'credit_6x' => 'bail|required|min:0',
            'price_9x' => 'bail|required|min:0',
            'credit_9x' => 'bail|required|min:0',
            'price_12x' => 'bail|required|min:0',
            'credit_12x' => 'bail|required|min:0',
        ]);

        DB::table('credit_schemes')
            ->where('id', $id)
            ->update([
                'product_id' => $request->product_id,
                'price_1x' => $request->price_1x,
                'credit_1x' => $request->credit_1x,
                'price_3x' => $request->price_3x,
                'credit_3x' => $request->credit_3x,
                'price_6x' => $request->price_6x,
                'credit_6x' => $request->credit_6x,
                'price_9x' => $request->price_9x,
                'credit_9x' => $request->credit_9x,
                'price_12x' => $request->price_12x,
                'credit_12x' => $request->credit_12x,
                'updated_at' => now()->toDateTimeString(),
            ]);

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
        DB::table('credit_schemes')->where('id', $id)->delete();

        return redirect()->route('credit_scheme.index')->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
        $col = [
            'products.product_name',
            'credit_scheme.price_1x',
            'credit_scheme.credit_1x',
            'credit_scheme.price_3x',
            'credit_scheme.credit_3x',
            'credit_scheme.price_6x',
            'credit_scheme.credit_6x',
            'credit_scheme.price_9x',
            'credit_scheme.credit_9x',
            'credit_scheme.price_12x',
            'credit_scheme.credit_12x',
        ];

        $query = DB::table('credit_schemes')
            ->select('credit_schemes.*', 'credit_schemes.id as scheme_id', 'products.product_name')
            ->join('products', 'credit_schemes.product_id', '=', 'products.id');

        if (!empty($request->search['value'])) {
            $query->where('products.product_name', 'like', '%' . $request->search['value'] . '%');
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
                $r->product_name,
                'Rp ' . number_format($r->price_1x, 0, ',', '.'),
                'Rp ' . number_format($r->credit_1x, 0, ',', '.'),
                'Rp ' . number_format($r->price_3x, 0, ',', '.'),
                'Rp ' . number_format($r->credit_3x, 0, ',', '.'),
                'Rp ' . number_format($r->price_6x, 0, ',', '.'),
                'Rp ' . number_format($r->credit_6x, 0, ',', '.'),
                'Rp ' . number_format($r->price_9x, 0, ',', '.'),
                'Rp ' . number_format($r->credit_9x, 0, ',', '.'),
                'Rp ' . number_format($r->price_12x, 0, ',', '.'),
                'Rp ' . number_format($r->credit_12x, 0, ',', '.'),
                '<a class="btn btn-info btn-sm" href="' . route('credit_scheme.edit', $r->scheme_id) . '">Edit</a>
                 <form method="post" action="' . route('credit_scheme.destroy', $r->scheme_id) . '" style="display:inline;">
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

    private function products()
    {
        $products = DB::table('products')
            ->where('active', 1)
            ->whereNotIn('id', function ($query) {
                $query->select('product_id')->from('credit_schemes');
            })->get();

        return $products;
    }
}
