<?php

namespace App\Http\Controllers;

use App\DataTables\HouseExpensesDataTable;
use App\Http\Requests\StoreHouseExpenseRequest;
use App\Http\Requests\UpdateHouseExpenseRequest;
use App\Models\HouseExpense;
use App\Services\HouseExpenseService;
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
            'sum_expenses' => number_format($sum_expenses, 0, ','),
        ]);
    }
    public function indexHouse2()
    {
        $house = 'house2';
        $sum_expenses = HouseExpense::where('house_name', '=', 'house2')->sum('amount');
        $houseExpensesDataTable = new HouseExpensesDataTable($house);
        return $houseExpensesDataTable->render('house_expenses.index', [
            'house' => $house,
            'sum_expenses' => number_format($sum_expenses, 0, ','),
        ]);
    }
    public function store(StoreHouseExpenseRequest $request, HouseExpenseService $houseExpenseService)
    {
        $validated_data = $request->validated();
        $message = $houseExpenseService->store($validated_data);

        return $message;
    }
    public function update(UpdateHouseExpenseRequest $request, HouseExpense $houseExpense, HouseExpenseService $houseExpenseService)
    {
        $validated_data = $request->validated();
        $message = $houseExpenseService->update($houseExpense, $validated_data);

        return $message;
    }
    public function destroy(HouseExpense $houseExpense, HouseExpenseService $houseExpenseService)
    {
        $message = $houseExpenseService->delete($houseExpense);

        return $message;
    }
}
