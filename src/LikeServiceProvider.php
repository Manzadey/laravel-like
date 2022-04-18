<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LikeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/create_likes_table.php' => database_path('migrations/' . date('Y_m_d_His') . 'create_likes_table.php'),
        ], 'favorite-migrations');
    }
}
