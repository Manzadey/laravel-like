<?php

declare(strict_types=1);

namespace Manzadey\LaravelLike\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Manzadey\LaravelLike\Contracts\LikeabilityContract;
use Manzadey\LaravelLike\Contracts\LikeableContract;

/**
 * @see LikeabilityContract
 */
trait Likeability
{
    public static function bootLikeability() : void
    {
        static::deleted(static function(LikeabilityContract $model) {
            $model->likes()->delete();
        });
    }

    /**
     * @see LikeabilityContract::favorites()
     */
    public function likes() : HasMany
    {
        return $this->hasMany(config('like.model'));
    }

    /**
     * @see LikeabilityContract::like()
     */
    public function like(LikeableContract $model) : Model
    {
        return $model->like($this);
    }

    /**
     * @see LikeabilityContract::dislike()
     */
    public function dislike(LikeableContract $model) : Model
    {
        return $model->like($this, false);
    }

    /**
     * @see LikeabilityContract::toggleLike()
     */
    public function toggleLike(LikeableContract $model) : Model
    {
        return $model->toggleLike($this);
    }

    /**
     * @see LikeabilityContract::removeLikeable()
     */
    public function removeLikeable(LikeableContract $model) : void
    {
        $model->removeLikeable($this);
    }

    /**
     * @see LikeabilityContract::isLike()
     */
    public function isLike(LikeableContract $model) : bool
    {
        return $model->isLike($this);
    }

    /**
     * @see LikeabilityContract::isDislike()
     */
    public function isDislike(LikeableContract $model) : bool
    {
        return $model->isDislike($this);
    }

    /**
     * @see LikeabilityContract::getLike()
     */
    public function getLike(array $classes = [], bool $liked = true) : Collection
    {
        return $this->likes()
            ->when(count($classes) > 0, static fn(Builder $builder) : Builder => $builder->whereIn('likeable_type', $classes))
            ->where('liked', $liked)
            ->with('likeable')
            ->get()
            ->map(static fn($like) : LikeableContract => $like->getRelation('likeable'));
    }

    /**
     * @see LikeabilityContract::getDislike()
     */
    public function getDislike(array $classes = []) : Collection
    {
        return $this->getLike($classes, false);
    }
}
