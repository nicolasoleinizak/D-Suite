<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Libraries\Jasonres;

class IncomeController extends Controller
{
    public function index (Request $request){
        try {
            $params = [
                ['organization_id', '=', $request->organization_id]
            ];
            if($request->after){
                array_push($params, ['date', '>', $request->after]);
            }
            if($request->before){
                array_push($params, ['date', '<', $request->before]);
            }
            $limit = isset($request->limit)? $request->limit : 25;
            $incomes = Income::where($params)
                ->select('id', 'date', 'type', 'quantity', 'concept', 'value')
                ->paginate($limit);
            if($incomes){
                return Jasonres::success('', $incomes);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function retrieve (Request $request){
        try {
            $income = Income::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])  ->select('id', 'date', 'type', 'quantity', 'concept', 'value')
                ->first();
            if($income){
                return Jasonres::success('', $income);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function create (Request $request){
        try {
            $valid_fields = $request->validate([
                'type' => 'string|required',
                'quantity' => 'numeric',
                'concept' => 'string|required',
                'value' => 'numeric|required'
            ]);
            $income = new Income;
            $income->type = $request->type;
            $income->date = $request->date;
            $income->quantity = isset($request->quantity)? $request->quantity : 1;
            $income->concept = $request->concept;
            $income->value = $request->value;
            $income->organization_id = $request->organization_id;
            if($income->save()){
                return Jasonres::success('Income created successfully', $income);
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function update (Request $request){
        try {
            $income = Income::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();
            if($income){
                $income->type = isset($request->type)? $request->type : $income->type;
                $income->date = isset($request->date)? $request->date : $income->date;
                $income->quantity = isset($request->quantity)? $request->quantity : $income->quantity;
                $income->concept = isset($request->concept)? $request->concept : $income->concept;
                $income->value = isset($request->value)? $request->value : $income->value;
                if($income->save()){
                    return Jasonres::success('Income created successfully', $income);
                } else {
                    return Jasonres::error('SRV001');
                }
            } else {
                return Jasonres::error('REQ001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function destroy (Request $request){
        try {
            $income = Income::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ]);
            if($income->delete()){
                return Jasonres::success('Income successfully deleted');
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
}
