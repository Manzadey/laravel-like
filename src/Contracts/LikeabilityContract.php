<?php

declare(strict_types=1);

namespace Manzadey\LaravelLike\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Add to a model that adds to favorites
 *
 * @see \Illuminate\Foundation\Auth\User
 */
interface LikeabilityContract
{
    /**
     * The relationship between the user and the likes models
     */
    public function likes() : HasMany;

    /**
     * Like a model
     */
    public function like(LikeableContract $model) : Model;

    /**
     * Dislike a model
     */
    public function dislike(LikeableContract $model) : Model;

    /**
     * The switch of the likes of this user
     */
    public function toggleLike(LikeableContract $model) : Model;

    /**
     * Remove like/dislike from this user
     */
    public function removeLikeable(LikeableContract $model) : void;

    /**
     * Checking the model - whether it is a like of this user
     */
    public function isLike(LikeableContract $model) : bool;

    /**
     * Checking the model - whether it is a like of this user
     */
    public function isDislike(LikeableContract $model) : bool;

    /**
     * We get a collection of models marked with a like
     */
    public function getLike(array $classes) : Collection;

    /**
     * We get a collection of models marked with a dislike
     */
    public function getDislike(array $classes) : Collection;
}
