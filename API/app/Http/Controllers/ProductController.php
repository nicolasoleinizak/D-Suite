<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Libraries\Jasonres;
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
        try {
            $products = Product::where([
                'organization_id' => $request->organization_id
            ])->get();

            if($products){
                return Jasonres::success('', $products);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
                'short_description' => 'required',
                'long_description' => 'string',
                'categories' => 'required|array'
            ]);

            $new_product = new Product;
            $new_product->short_description = $request->short_description;
            $new_product->long_description = $request->long_description;
            $new_product->organization_id = $request->organization_id;

            if($new_product->save()){
                if($new_product->assignCategories($request->categories)){
                    return Jasonres::success('Product created successfully', $new_product);
                }
            }

            return Jasonres::error('SRV001');
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retrieve(Request $request)
    {
        try {
            $product = Product::where([
                'id' => $request->product_id,
                'organization_id' => $request->organization_id
            ])->with('categories')->get();

            if($product){
                return Jasonres::success('', $product);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $validationData = $request->validate([
                'short_description' => 'required|string',
                'long_description' => 'string',
                'categories' => 'required|array'
            ]);

            $product = Product::where([
                'id' => $request->product_id,
                'organization_id' => $request->organization_id
            ])->first();

            if($product){
                $product->short_description = $request->short_description;
                $product->long_description = $request->long_description;
                if($product->save()){
                    if($product->assignCategories($request->categories)){
                        return Jasonres::success('Product updated successfully', $product);
                    }
                }
                return Jasonres::error('SRV001');
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $product = Product::where([
                'id' => $request->product_id,
                'organization_id' => $request->organization_id
            ]);
    
            if($product->delete()){
                return Jasonres::success('Product successfully deleted');
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
}
