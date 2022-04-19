<?php

namespace Manzadey\LaravelLike\Test\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Manzadey\LaravelLike\Contracts\LikeabilityContract;
use Manzadey\LaravelLike\Traits\Likeability;

class User extends Authenticatable implements LikeabilityContract
{
    use Likeability;

    protected $guarded = [];
}
