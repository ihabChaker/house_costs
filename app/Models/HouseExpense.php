<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseExpense extends Model
{
    use HasFactory;
    protected $fillable = ['expense_name', 'house_name', 'amount', 'date', 'spender_id'];
    public function spender()
    {
        return $this->belongsTo(Employee::class, 'spender_id');
    }

    public function dashboardExpense()
    {
        return $this->setConnection('mysql1')->hasOne(Expense::class, 'house_expense_id');
    }
}