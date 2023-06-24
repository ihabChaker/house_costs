<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spender extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function expenses()
    {
        return $this->hasMany(HouseExpense::class, 'spender_id');
    }
}
