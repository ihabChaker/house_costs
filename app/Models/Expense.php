<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $connection = 'mysql1';

    protected $fillable = ['name', 'amount', 'house_expense_id', 'spender_id'];

}