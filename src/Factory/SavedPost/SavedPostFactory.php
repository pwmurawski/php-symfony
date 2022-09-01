<?php

declare(strict_types=1);

namespace App\Factory\SavedPost;

use App\Entity\Post;
use App\Entity\SavedPost;
use Symfony\Component\Uid\Uuid;

class SavedPostFactory implements SavedPostFactoryInterface
{
    public function create(Uuid $id, Uuid $userId, Post $post): SavedPost
    {
        return new SavedPost($id, $userId, $post);
    }
}
