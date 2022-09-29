<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where('company_id', Auth::user()->company_id)
            ->whereIn('id', function ($q) {
                $q->select('product_id')->from('credit_schemes')->where('deleted_at', null);
            })
            ->where('active', 1)
            ->orderBy('product_name')
            ->simplePaginate(18);

        return view('barang.index', [
            'products' => $products,
            'display' => $request->display,
        ]);
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
        $product = DB::table('products')
            ->where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->first();

        $schemes = DB::table('credit_schemes')
            ->where('product_id', $id)
            ->where('price', '<=', function ($q) {
                $q->select('grades.max_credit')
                    ->from('grades')
                    ->join('employees', 'employees.grade_id', '=', 'grades.id')
                    ->where('employees.user_id', Auth::user()->id);
            })
            ->get();

        $submitable = DB::table('submissions')
            ->where('user_id', Auth::user()->id)
            ->whereIn('payment_status', ['unpaid', 'progress'])
            ->first();

        $submitable = ($submitable == null);

        return view('barang.show', [
            'product' => $product,
            'credit_schemes' => $schemes,
            'submitable' => $submitable
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
        $col = ['product_name', 'product_brand'];

        $query = Product::where('company_id', $request->company_id)
            ->whereIn('id', function ($q) {
                $q->select('product_id')->from('credit_schemes')->where('deleted_at', null);
            })
            ->where('active', 1);

        if (!empty($request->search['value'])) {
            $query->where(function ($q) use ($request, $col) {
                $q->oRwhere('product_name', 'like', '%' . $request->search['value'] . '%')
                    ->oRwhere('product_brand', 'like', '%' . $request->search['value'] . '%');
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
                $r->product_image == null ? '-' : '<a data-fancybox href=' . asset($r->product_image) . '>Gambar</a>',
                // $r->product_description,
                '<a class="btn btn-primary btn-sm" href="' . route('barang.show', $r->id) . '">Detail</a>',
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
