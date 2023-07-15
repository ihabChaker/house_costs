<?php

namespace App\Observers;

use App\Models\HouseExpense;

class HouseExpenseObserver
{
    /**
     * Handle the HouseExpense "created" event.
     */
    public function created(HouseExpense $houseExpense): void
    {
        $houseExpense->dashboardExpense()->create([
            'name' => $houseExpense->expense_name . ' الديار ',
            'amount' => $houseExpense->amount,
            'spender_id' => $houseExpense->spender_id,
        ]);
    }

    /**
     * Handle the HouseExpense "updated" event.
     */
    public function updated(HouseExpense $houseExpense): void
    {
        $houseExpense->dashboardExpense()->update([
            'name' => $houseExpense->expense_name . ' الديار ',
            'amount' => $houseExpense->amount,
            'spender_id' => $houseExpense->spender_id,
        ]);
    }

    /**
     * Handle the HouseExpense "deleted" event.
     */
    public function deleted(HouseExpense $houseExpense): void
    {
        $houseExpense->dashboardExpense()->delete();
    }

    /**
     * Handle the HouseExpense "restored" event.
     */
    public function restored(HouseExpense $houseExpense): void
    {
        //
    }

    /**
     * Handle the HouseExpense "force deleted" event.
     */
    public function forceDeleted(HouseExpense $houseExpense): void
    {
        //
    }
}