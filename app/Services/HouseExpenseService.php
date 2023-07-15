<?php

namespace App\Services;

use App\Models\HouseExpense;

class HouseExpenseService
{
    public function store($data)
    {
        HouseExpense::create([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'house_name' => $data['house_name'],
            'expense_name' => $data['expense_name'],
            'spender_id' => $data['spender_id'],
        ]);

        return ['message' => 'تم الحفظ بنجاح'];
    }

    public function update($houseExpense, $data)
    {
        $houseExpense->update([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'expense_name' => $data['expense_name'],
            'spender_id' => $data['spender_id'],
        ]);

        return ['message' => 'تم الحفظ بنجاح'];
    }

    public function delete($houseExpense)
    {
        $houseExpense->delete();

        return ['message' => 'تم الحذف بنجاح'];
    }
}