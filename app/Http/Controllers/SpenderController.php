<?php

namespace App\Http\Controllers;

use App\DataTables\HouseExpensesDataTable;
use App\DataTables\SpenderDataTable;
use App\Models\HouseExpense;
use App\Models\Spender;
use App\Services\SpenderService;
use Illuminate\Http\Request;

class SpenderController extends Controller
{
    public function index(SpenderDataTable $spenderDataTable)
    {
        return $spenderDataTable->render('spenders.index');
    }

    public function store(Request $request)
    {
        $expense = new Spender();

        $expense->name = $request->input('name');
        $expense->save();
        return ['message' => 'spender saved successfully'];
    }
    public function update(Request $request, Spender $spender)
    {
        $spender->name = $request->input('name');
        $spender->save();
        return ['message' => 'expense updated successfully'];
    }
    public function destroy(Request $request, Spender $spender)
    {
        $spender->delete();
        return ['message' => 'expense deleted successfully'];
    }
    public function generateSelectOptions(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->has('q') ? $request->q : '';
            $data = SpenderService::generateSelectOptions($search);
        }
        return response()->json($data);
    }
}
