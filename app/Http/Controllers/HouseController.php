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
        $sum_expenses = HouseExpense::where('house_name', '=', 'house1')->sum('amount');
        $houseExpensesDataTable = new HouseExpensesDataTable($house);
        return $houseExpensesDataTable->render('house_expenses.index', [
            'house' => $house,
            'sum_expenses' => $sum_expenses,
        ]);
    }
    public function indexHouse2()
    {
        $house = 'house2';
        $sum_expenses = HouseExpense::where('house_name', '=', 'house2')->sum('amount');
        $houseExpensesDataTable = new HouseExpensesDataTable($house);
        return $houseExpensesDataTable->render('house_expenses.index', [
            'house' => $house,
            'sum_expenses' => $sum_expenses,
        ]);
    }
    public function store(Request $request)
    {
        $expense = new HouseExpense();
        $expense->amount = $request->input('amount');
        $expense->date = $request->input('date');
        $expense->house_name = $request->input('house_name');
        $expense->expense_name = $request->input('expense_name');
        $expense->spender_id = $request->input('spender_id');
        $expense->save();
        DashboardExpenseController::store($request, $expense->id);
        return ['message' => 'expense saved successfully'];
    }
    public function update(Request $request, HouseExpense $houseExpense)
    {
        $houseExpense->amount = $request->input('amount');
        $houseExpense->date = $request->input('date');
        $houseExpense->expense_name = $request->input('expense_name');
        $houseExpense->spender_id = $request->input('spender_id');
        $houseExpense->save();
        $dashboardExpense = $houseExpense->dashboardExpense;
        DashboardExpenseController::update($dashboardExpense, $request, $houseExpense->id);

        return ['message' => 'expense updated successfully'];
    }
    public function destroy(Request $request, HouseExpense $houseExpense)
    {
        $houseExpense->delete();
        $houseExpense->dashboardExpense()->delete();

        return ['message' => 'expense deleted successfully'];
    }
}