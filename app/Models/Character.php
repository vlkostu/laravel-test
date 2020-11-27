<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    protected $fillable = [
        'name',
        'birthday',
        'occupations',
        'img',
        'nickname',
        'portrayed'
    ];

    /**
     * @var int
     */

    protected $perPage = 10;

    /**
     * @var string[]
     */

    protected $dates = [
        'birthday'
    ];

    /**
     * @var string[]
     */

    protected $casts = [
        'occupations' => 'array'
    ];

    /**
     * @return HasMany
     */

    public function quotes() : HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * @return BelongsToMany
     */

    public function episodes() : BelongsToMany
    {
        return $this->belongsToMany(Episode::class);
    }
}
