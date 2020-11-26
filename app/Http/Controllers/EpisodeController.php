<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{

    /**
     * Get all episodes
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAll(Request $request)
    {
        return response()->json(
            Episode::query()->paginate($request->get('limit'))
        );
    }

    /**
     * Get episode by id
     *
     * @param Episode $episode
     * @return \Illuminate\Http\JsonResponse
     */

    public function getByID(Episode $episode)
    {
        return response()->json(
            $episode->with('characters')->firstOrFail()
        );
    }
}
