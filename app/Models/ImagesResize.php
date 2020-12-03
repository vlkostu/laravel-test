<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagesResize extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'width',
        'path'
    ];

    /**
     * @return BelongsTo
     */

    public function image() : BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
