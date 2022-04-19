<?php

namespace Manzadey\LaravelLike\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Manzadey\LaravelLike\Contracts\LikeableContract;
use Manzadey\LaravelLike\Traits\Likeable;

class Post extends Model implements LikeableContract
{
    use Likeable;

    protected $guarded = [];
}
