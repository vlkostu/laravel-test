<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Get all characters
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function getAll(Request $request)
    {
        return response()->json(
            Character::query()
                ->with(['episodes', 'quotes'])
                ->when($request->get('name'), function (Builder $builder) use ($request) {
                    $builder->where('name', 'LIKE', "%{$request->get('name')}%");
                })
                ->paginate($request->get('limit'))
        );
    }

    /**
     * Get random character
     *
     * @return JsonResponse
     */

    public function getRandom()
    {
        return response()->json(
            Character::query()
                ->inRandomOrder()
                ->firstOrFail()
        );
    }
}
