<?php

namespace App\Form\Comment\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use App\Repository\Post\PostRepositoryInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PostExistValidator extends ConstraintValidator
{
    public PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $post = $this->postRepository->getById(new Uuid($value));

        if ($post) {
            return;
        }

        $this->context->buildViolation('Post not Exist')->addViolation();
    }
}
