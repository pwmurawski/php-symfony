<?php

declare(strict_types=1);

namespace App\Factory\SavedPost;

use App\Entity\Post;
use App\Entity\SavedPost;
use Symfony\Component\Uid\Uuid;

interface SavedPostFactoryInterface
{
    public function create(Uuid $id, Uuid $userId, Post $post): SavedPost;
}
