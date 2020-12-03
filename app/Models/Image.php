<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    protected $fillable = [
        'url',
        'path',
        'delete_at',
    ];

    /**
     * @var string[]
     */

    protected $dates = [
        'delete_at'
    ];

    /**
     * @return HasMany
     */

    public function imageResizes() : HasMany
    {
        return $this->hasMany(ImagesResize::class);
    }

    /**
     * @return HasMany
     */

    public function imageTags() : HasMany
    {
        return $this->hasMany(ImagesTag::class);
    }

    /**
     * Get user images
     *
     * @param $request
     * @return mixed
     */

    public function getImages(Request $request)
    {
        return self::with(['imageResizes', 'imageTags'])
        ->when($request->get('tags'), function ($query) use ($request) {
            $this->explodeTags($request)->each(function ($tag) use ($query, $request) {
                $query->whereHas('imageTags', function (Builder $builder) use ($request, $tag) {
                    $builder->where('name', $tag);
                });
            });
        })
        ->paginate();
    }

    /**
     * Explode tags
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */

    public function explodeTags(Request $request)
    {
        return Str::of($request->get('tags'))->explode(',');
    }
}
