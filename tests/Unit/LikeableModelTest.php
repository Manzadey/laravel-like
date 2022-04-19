<?php

namespace Manzadey\LaravelLike\Test\Unit;

use Manzadey\LaravelLike\Contracts\LikeabilityContract;
use Manzadey\LaravelLike\Contracts\LikeableContract;
use Manzadey\LaravelLike\Models\Like;
use Manzadey\LaravelLike\Test\TestCase;

class LikeableModelTest extends TestCase
{
    public function testLike() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $like = $article->like($user);
        $this->assertCount(1, $article->likeable);
        $this->assertTrue($like->liked);

        /* @var LikeableContract $post */
        $post = $this->posts->get(0);
        $like = $post->like($user);
        $this->assertCount(1, $post->likeable);
        $this->assertTrue($like->liked);

        $this->assertCount(2, $user->likes);
    }

    public function testDislike() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $like = $article->dislike($user);
        $this->assertCount(1, $article->likeable);
        $this->assertFalse($like->liked);
    }

    public function testAddToLikeUsers() : void
    {
        /* @var LikeableContract $post */
        $post = $this->posts->get(0);

        $usersCount = 3;
        foreach ($this->users->take($usersCount) as $user) {
            $post->like($user);
        }
        $post->load('likeable');
        $this->assertCount($usersCount, $post->likeable);
    }

    public function testAddToLikeDuplicated() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $article->like($user);
        $article->like($user);
        $article->like($user);
        $this->assertCount(1, $article->likeable);

        /* @var LikeableContract $post */
        $post = $this->posts->get(0);
        $post->like($user);
        $post->like($user);
        $post->like($user);

        $this->assertCount(1, $post->likeable);

        $this->assertCount(2, $user->Likes);
    }

    public function testIsLike() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $article->like($user);
        $this->assertTrue($article->isLike($user));

        /* @var LikeableContract $post */
        $post = $this->posts->get(0);
        $post->like($user);
        $this->assertTrue($post->isLike($user));
        $post->dislike($user);
        $this->assertTrue($post->isDislike($user));
    }

    public function testIsLikes() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $article->like($user);
        $this->assertTrue($article->isLikes());
        $article->dislike($user);
        $this->assertTrue($article->isDislikes());
    }

    public function testRemoveLikeFromUser() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $article->like($user);
        $this->assertCount(1, $article->likeable);
        $article->removeLikeable($user);
        $article->load('likeable');
        $this->assertCount(0, $article->likeable);

        /* @var LikeableContract $post */
        $post = $this->posts->get(0);
        $post->like($user);
        $this->assertCount(1, $post->likeable);
        $post->removeLikeable($user);
        $post->load('likeable');
        $this->assertCount(0, $post->likeable);
    }

    public function testToggleLike() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $article->toggleLike($user);
        $article->load('likeable');
        $this->assertCount(1, $article->likeable);

        $article->toggleLike($user);
        $article->load('likeable');
        $this->assertCount(0, $article->likeable->where('liked', true));

        /* @var LikeableContract $article */
        $article = $this->articles->get(1);
        $this->assertTrue($article->toggleLike($user)->liked);
        $this->assertFalse($article->toggleLike($user)->liked);

        $this->assertTrue($user->toggleLike($article)->liked);
        $this->assertFalse($user->toggleLike($article)->liked);
    }

    public function testLikeBy() : void
    {
        /* @var LikeableContract $article */
        $article = $this->articles->get(0);

        /* @var LikeabilityContract $user */
        foreach ($this->users->take(10) as $user) {
            $article->like($user);
        }

        $this->assertCount(10, $article->LikeBy());
    }

    public function testLikeByWithDeletingUserModels() : void
    {
        /* @var LikeableContract $article */
        $article = $this->articles->get(0);

        $userIdsForDeleting = [1, 5, 10, 6];
        $countUsers         = 10;

        /* @var LikeabilityContract $user */
        foreach ($this->users->take($countUsers) as $user) {
            $article->like($user);

            if(in_array($user->id, $userIdsForDeleting, true)) {
                $user->delete();
            }
        }

        $this->assertCount($countUsers - count($userIdsForDeleting), $article->LikeBy());
    }

    public function testDeletedEvent() : void
    {
        /* @var LikeabilityContract $user */
        $user = $this->users->get(0);

        /* @var LikeableContract $article */
        $article = $this->articles->get(0);
        $article->like($user);
        $this->assertCount(1, $article->likeable);

        $LikeQuery = Like::where('user_id', $user->id)->where('Likeable_type', $article->getMorphClass())->where('Likeable_id', $article->id);
        $this->assertTrue($LikeQuery->exists());

        $article->delete();
        $this->assertFalse($LikeQuery->exists());
    }
}
