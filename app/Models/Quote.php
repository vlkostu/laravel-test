<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    protected $fillable = [
        'quote'
    ];

    /**
     * @var int
     */

    protected $perPage = 10;

    /**
     * @return BelongsTo
     */

    public function character() : BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * @return BelongsTo
     */

    public function episode() : BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }
}
