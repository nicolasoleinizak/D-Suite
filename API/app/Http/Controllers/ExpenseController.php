<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Libraries\Jasonres;

class ExpenseController extends Controller
{
    public function index(Request $request){
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
            $expenses = Expense::where($params)
                ->select('id', 'date', 'type', 'concept', 'value')
                ->paginate($limit);
            if($expenses){
                return Jasonres::success('', $expenses);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
    public function retrieve(Request $request){
        try {
            $expense = Expense::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->get();
            if($expense){
                return Jasonres::success('', $expense);
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
    public function create(Request $request){
        try {
            $request->validate([
                'type' => 'string|required',
                'date' => 'date|required',
                'concept' => 'string|required',
                'value' => 'numeric|required',
            ]);
            $expense = new Expense;
            $expense->date = $request->date;
            $expense->type = $request->type;
            $expense->concept = $request->concept;
            $expense->value = $request->value;
            $expense->organization_id = $request->organization_id;
            if($expense->save()){
                return Jasonres::success('', $expense);
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
    public function update(Request $request){
        try {
            $expense = Expense::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();
            if($expense){
                $expense->type = isset($request->type)? $request->type : $expense->type;
                $expense->concept = isset($request->concept)? $request->concept : $expense->concept;
                $expense->value = isset($request->value)? $request->value : $expense->value;
                if($expense->save()){
                    return Jasonres::success('Income created successfully', $expense);
                } else {
                    return Jasonres::error('SRV001');
                }
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
    public function destroy(Request $request){
        try {
            $expense = Expense::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ]);
            if($expense->delete()){
                return Jasonres::success('Expense deleted successfully');
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
}
