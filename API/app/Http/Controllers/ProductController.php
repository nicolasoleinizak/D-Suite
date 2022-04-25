<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(['data' => Product::where([
            'organization_id' => $request->organization_id
            ])->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validationData = $request->validate([
            'short_description' => 'required',
            'long_description' => 'string',
            'categories' => 'required|array'
        ]);

        $new_product = new Product;
        $new_product->short_description = $request->short_description;
        $new_product->long_description = $request->long_description;
        $new_product->organization_id = $request->organization_id;
        $new_product->save();
        $new_product->assignCategories($request->categories);
        $new_product->categories;
        return response()->json(['data' => $new_product]);
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function retrieve(Request $request)
    {
        return response()->json(['data' => Product::where([
            'id' => $request->product_id,
            'organization_id' => $request->organization_id
            ])->get()]);
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
    public function update(Request $request)
    {
        $validationData = $request->validate([
            'short_description' => 'required|string',
            'long_description' => 'string',
            'categories' => 'required|array'
        ]);

        $product = Product::where([
            'id' => $request->product_id,
            'organization_id' => $request->organization_id
        ]);

        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->save();
        $product->assignCategories($request->categories);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
