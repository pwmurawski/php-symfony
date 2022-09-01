<?php

namespace App\Form\SavedPost\Validator\Constraints;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraint;

class NotSavedPost extends Constraint
{
    public Uuid $userId;

    public function __construct(Uuid $userId)
    {
        $this->userId = $userId;

        parent::__construct();
    }
}
