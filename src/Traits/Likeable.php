<?php

declare(strict_types=1);

namespace Manzadey\LaravelLike\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Manzadey\LaravelLike\Contracts\LikeabilityContract;
use Manzadey\LaravelLike\Contracts\LikeableContract;
use Manzadey\LaravelLike\Models\Like;

/**
 * Add to a model that is like
 */
trait Likeable
{
    public static function bootLikeable() : void
    {
        static::deleted(static function(LikeableContract $model) {
            $model->likeable()->delete();
        });
    }

    public function likeable() : MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like(LikeabilityContract $user, bool $liked = true) : Like
    {
        return $this->likeable()->updateOrCreate([
            'user_id'       => $user->id,
            'likeable_id'   => $this->id,
            'likeable_type' => $this->getMorphClass(),
        ], compact('liked'));
    }

    public function dislike(LikeabilityContract $user) : Like
    {
        return $this->like($user, false);
    }

    public function toggleLike(LikeabilityContract $user) : Like
    {
        return $this->like($user, !$this->isLike($user));
    }

    public function removeLikeable(LikeabilityContract $user) : void
    {
        $this->likeable()->where('user_id', $user->id)->delete();
    }

    public function isLike(LikeabilityContract $user, bool $liked = true) : bool
    {
        return $this->likeable()->where('user_id', $user->id)->where('liked', $liked)->exists();
    }

    public function isDislike(LikeabilityContract $user) : bool
    {
        return $this->isLike($user, false);
    }

    public function isLikes(bool $liked = true) : bool
    {
        return $this->likeable()->where('liked', $liked)->exists();
    }

    public function isDislikes() : bool
    {
        return $this->isLikes(false);
    }

    public function likeBy(bool $liked = true) : Collection
    {
        return $this->likeable()->with('user')
            ->where('liked', $liked)
            ->get()
            ->map(static fn(Like $like) => $like->getRelation('user'))
            ->filter();
    }

    public function dislikeBy() : Collection
    {
        return $this->likeBy(false);
    }
}
