<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class StatisticController extends Controller
{
    /**
     * Get all stats
     *
     * @return JsonResponse
     */

    public function getAll()
    {
        return response()->json(
            Cache::get('api-total-requests', 0)
        );
    }

    /**
     * Get stats auth user
     *
     * @return JsonResponse
     */

    public function getUser()
    {
        return response()->json(
            Cache::get('api:users:'.auth()->id(), 0)
        );
    }
}
