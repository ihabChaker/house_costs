<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $connection = 'mysql1';

    protected $fillable = ['name', 'amount', 'house_expense_id', 'spended_by'];
    // public function spender()
    // {
    //     return $this->belongsTo(Spender::class, 'spended_by');
    // }
    // public function houseExpense()
    // {
    //     return $this->setConnection('mysql')->belongsTo(HouseExpense::class, 'house_expense_id');
    // }
}