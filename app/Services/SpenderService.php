<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SpenderService
{
    public static function generateSelectOptions($search)
    {
        $options = DB::table('spenders')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            })->select('id', 'name as text')
            ->paginate(10);
        return $options;
    }
}
