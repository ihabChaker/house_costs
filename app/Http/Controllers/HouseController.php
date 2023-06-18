<?php

namespace App\Http\Controllers;

use App\DataTables\HouseExpensesDataTable;
use App\Models\HouseExpense;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function indexHouse1()
    {
        $house = 'house1';
        $houseExpensesDataTable = new HouseExpensesDataTable($house);
        return $houseExpensesDataTable->render('house_expenses.index', [
            'house' => $house
        ]);
    }
    public function indexHouse2()
    {
        $house = 'house2';
        $houseExpensesDataTable = new HouseExpensesDataTable($house);
        return $houseExpensesDataTable->render('house_expenses.index', [
            'house' => $house
        ]);
    }
    public function store(Request $request)
    {
        $expense = new HouseExpense();
        $expense->amount = $request->input('amount');
        $expense->date = $request->input('date');
        $expense->house_name = $request->input('house_name');
        $expense->expense_name = $request->input('expense_name');
        $expense->spender_name = $request->input('spender_name');
        $expense->save();
        return ['message' => 'expense saved successfully'];
    }
    public function update(Request $request, HouseExpense $houseExpense)
    {
        $houseExpense->amount = $request->input('amount');
        $houseExpense->date = $request->input('date');
        $houseExpense->expense_name = $request->input('expense_name');
        $houseExpense->spender_name = $request->input('spender_name');
        $houseExpense->save();
        return ['message' => 'expense updated successfully'];
    }
    public function destroy(Request $request, HouseExpense $houseExpense)
    {
        $houseExpense->delete();
        return ['message' => 'expense deleted successfully'];
    }
}
