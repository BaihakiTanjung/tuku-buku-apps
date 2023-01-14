<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Product::all();

        return response()->json($response, 200);
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

        $lastCode = Product::orderBy('id', 'desc')->first();
        $nameCode = 'B' . $lastCode->id + 1;

        $response = Product::create(
            [
                'code' => $nameCode,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $request->image,
                'price' => $request->price,
                'qty' => $request->qty,
                'stock' => $request->stock,
                'supplier_id' => 1,
            ]
        );

        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'data' => $response
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $response = Product::destroy($id);

        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'data' => $response
            ]
        );
    }
}
