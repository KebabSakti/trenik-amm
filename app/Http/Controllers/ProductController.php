<?php

namespace App\Http\Controllers;

use App\Modules\FileModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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
            'product_name' => 'bail|required',
            'product_brand' => 'bail|required',
        ]);

        $file = null;

        if ($request->hasFile('file')) {
            $file = FileModule::upload($request);
        }

        DB::table('products')->insert([
            'company_id' => $request->user()->company_id,
            'product_name' => $request->product_name,
            'product_brand' => $request->product_brand,
            'product_image' => $file,
            'product_description' => $request->product_description,
            'active' => $request->active == true ? 1 : 0,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return redirect()->route('product.index')->with('alert', 'Data berhasil di proses');
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
        $model = DB::table('products')->where('id', $id)->first();

        return view('product.edit', ['model' => $model]);
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
            'product_name' => 'bail|required',
            'product_brand' => 'bail|required',
        ]);

        $product = DB::table('products')->where('id', $id)->first();

        if ($product == null) {
            return redirect()->route('product.index')->withErrors('Data tidak ditemukan');
        }

        $file = $product->product_image;

        if ($request->hasFile('file')) {
            if ($file != null) {
                //delete old file
                FileModule::delete($file);
            }

            $file = FileModule::upload($request);
        }

        DB::table('products')
            ->where('id', $id)
            ->update([
                'product_name' => $request->product_name,
                'product_brand' => $request->product_brand,
                'product_image' => $file,
                'product_description' => $request->product_description,
                'active' => $request->active == true ? 1 : 0,
                'updated_at' => now()->toDateTimeString(),
            ]);

        return redirect()->route('product.index')->with('alert', 'Data berhasil di proses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if ($product == null) {
            return redirect()->route('product.index')->withErrors('Data tidak ditemukan');
        }

        $file = $product->product_image;

        if ($file != null) {
            FileModule::delete($file);
        }

        DB::table('products')->where('id', $id)->delete();

        return redirect()->route('product.index')->with('alert', 'Data berhasil di proses');
    }

    public function indexJSON(Request $request)
    {
        $col = [
            'product_name',
            'product_brand',
            '',
            'active',
        ];

        $query = DB::table('products');

        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->where('product_name', 'like', '%' . $request->search['value'] . '%')
                    ->orWhere('product_brand', 'like', '%' . $request->search['value'] . '%');
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
                $r->product_name,
                $r->product_brand,
                $r->product_image == null ? '-' : '<a data-fancybox href=' . asset($r->product_image) . '>Lihat Gambar</a>',
                $r->active == 1 ? 'Aktif' : 'Non Aktif',
                '<a class="btn btn-info btn-sm" href="' . route('product.edit', $r->id) . '">Edit</a>
                 <form method="post" action="' . route('product.destroy', $r->id) . '" style="display:inline;">
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
