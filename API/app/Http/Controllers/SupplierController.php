<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Libraries\Jasonres;


class SupplierController extends Controller
{
    public function index(Request $request){
        try{
            $suppliers = Supplier::where([
                'organization_id' => $request->organization_id
            ])->get();

            if($suppliers){
                return Jasonres::success('', $suppliers);
            } else{
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    public function retrieve(Request $request){
        try{
            $supplier = Supplier::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->get();

            if($supplier){
                return Jasonres::success('', $supplier);
            } else{
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    public function create(Request $request){

        $request->validate([
            'name' => 'string|required',
            'address' => 'string',
            'email' => 'string',
            'phone' => 'string',
        ]);

        try{

            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->address = isset($request->address) ? $request->address : null;
            $supplier->email = isset($request->email) ? $request->email : null;
            $supplier->phone = isset($request->phone) ? $request->phone : null;
            $supplier->organization_id = $request->organization_id;
            if($supplier->save()){
                return Jasonres::success('Supplier successfully created', $supplier);
            } else {
                return Jasonres::error('SRV001');
            }

        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }
    
    public function update(Request $request){

        $request->validate([
            'name' => 'string',
            'address' => 'string',
            'email' => 'string',
            'phone' => 'string',
        ]);

        try{

            $supplier = Supplier::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();

            if(!$supplier){
                return Jasonres::error('REQ002');
            }

            $supplier->name = isset($request->name) ? $request->name : $supplier->name;
            $supplier->address = isset($request->address) ? $request->address : $supplier->address;
            $supplier->email = isset($request->email) ? $request->email : $supplier->email;
            $supplier->phone = isset($request->phone) ? $request->phone : $supplier->phone;

            if($supplier->save()){
                return Jasonres::success('Supplier successfully updated', $supplier);
            } else{
                return Jasonres::error('SRV001');
            }

        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    public function destroy(Request $request){


        try{

            $supplier = Supplier::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ]);

            if(!$supplier->first()){
                return Jasonres::error('REQ002');
            }

            if($supplier->delete()){
                return Jasonres::success('Supplier deleted successfully');
            } else{
                return Jasonres::error('SRV001');
            }

        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }
}
