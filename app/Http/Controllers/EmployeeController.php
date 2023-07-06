<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function generateSelectOptions(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->has('q') ? $request->q : '';
            $data = EmployeeService::generateSelectOptions($search);
        }
        return response()->json($data);
    }
}