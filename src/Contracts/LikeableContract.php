<?php

declare(strict_types=1);

namespace Manzadey\LaravelLike\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Manzadey\LaravelLike\Models\Like;

interface LikeableContract
{
    /**
     * MorphMany Relationship
     */
    public function likeable() : MorphMany;

    /**
     * Add the current model to like of the specified user
     */
    public function like(LikeabilityContract $user) : Like;

    /**
     * Add the current model to dislike of the specified user
     */
    public function dislike(LikeabilityContract $user) : Like;

    /**
     * The switch of the like of the specified user
     */
    public function toggleLike(LikeabilityContract $user) : Like;

    /**
     * Delete the current module from the likes of the specified user
     */
    public function removeLikeable(LikeabilityContract $user) : void;

    /**
     * Check the current model whether it is a likes of the specified user
     */
    public function isLike(LikeabilityContract $user) : bool;

    /**
     * Check the current model whether it is a dislikes of the specified user
     */
    public function isDislike(LikeabilityContract $user) : bool;

    /**
     * Check the current model, whether it is marked with a like
     */
    public function isLikes() : bool;

    /**
     * Check the current model, whether it is marked with a dislike
     */
    public function isDislikes() : bool;

    /**
     * Return a collection with the Users who marked as like this model.
     */
    public function likeBy() : Collection;

    /**
     * Return a collection with the Users who marked as dislike this model.
     */
    public function dislikeBy() : Collection;
}
