<?php

declare(strict_types=1);

namespace Manzadey\LaravelLike;

use Illuminate\Support\ServiceProvider;

class LikeServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/create_likes_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_likes_table.php'),
        ], 'like-migrations');
    }
}
