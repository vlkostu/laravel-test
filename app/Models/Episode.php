<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Episode extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    protected $fillable = [
        'title', 'air_date'
    ];

    /**
     * @var int
     */

    protected $perPage = 10;

    /**
     * @var string[]
     */

    protected $dates = ['air_date'];

    /**
     * @return BelongsToMany
     */

    public function characters() : BelongsToMany
    {
        return $this->belongsToMany(Character::class);
    }

    /**
     * @return HasMany
     */

    public function quotes() : HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
