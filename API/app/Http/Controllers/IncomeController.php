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
            $incomes = Income::where($params)
                ->select('id', 'date', 'type', 'quantity', 'concept', 'value', 'created_at')
                ->get();
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

        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function create (Request $request){
        try {

        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function update (Request $request){
        try {

        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function destroy (Request $request){
        try {

        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
}
