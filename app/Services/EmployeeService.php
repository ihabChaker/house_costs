<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public static function generateSelectOptions($search)
    {
        $options = DB::connection('mysql1')->table('employees')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            })->select('id', 'name as text')
            ->paginate(10);
        return $options;
    }
}