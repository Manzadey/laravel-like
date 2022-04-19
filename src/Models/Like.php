<?php

declare(strict_types=1);

namespace Manzadey\LaravelLike\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'liked',
    ];

    protected $casts = [
        'liked' => 'boolean',
    ];

    public function likeable() : MorphTo
    {
        return $this->morphTo();
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function toggle() : void
    {
        $this->update([
            'liked' => !$this->liked,
        ]);
    }
}
