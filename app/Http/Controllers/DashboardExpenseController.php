<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardExpenseController extends Controller
{
    static public function store($request, $house_expense_id)
    {
        $expense = new Expense();
        $expense->name = $request->input('expense_name') . ' الديار ';
        $expense->house_expense_id = $house_expense_id;
        $expense->amount = $request->input('amount');
        $expense->spender_id = $request->input('spender_id');
        $expense->save();
    }
    static public function update($expense, $request, $house_expense_id)
    {
        $expense->name = $request->input('expense_name') . ' الديار ';

        $expense->house_expense_id = $house_expense_id;
        $expense->amount = $request->input('amount');
        $expense->spender_id = $request->input('spender_id');
        $expense->save();
    }
}