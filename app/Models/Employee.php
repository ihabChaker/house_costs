<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $connection = "mysql1";
    protected $table = "employees";
    public function expenses()
    {
        return $this->setConnection('mysql')->hasMany(HouseExpense::class, 'spender_id');
    }
}