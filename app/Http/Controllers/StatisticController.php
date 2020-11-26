<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class StatisticController extends Controller
{
    /**
     * Get all stats
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAll()
    {
        return response()->json(
            Cache::get('api-total-requests')
        );
    }

    /**
     * Get stats auth user
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getUser()
    {
        return response()->json(
            Cache::get('api:users:'.auth()->id())
        );
    }
}
