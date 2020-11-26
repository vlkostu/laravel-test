<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QuoteController extends Controller
{

    /**
     * Get all quotes
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAll(Request $request)
    {
        return response()->json(
            Quote::query()->paginate($request->get('limit'))
        );
    }

    /**
     * Get random quote
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getRandom(Request $request)
    {
        return response()->json(
            Quote::query()
                ->inRandomOrder()
                ->with('character')
                ->whereHas('character', function (Builder $builder) use ($request) {
                    $builder->where('name', 'LIKE', "%{$request->get('author')}%");
                })
                ->firstOrFail()
        );
    }
}
