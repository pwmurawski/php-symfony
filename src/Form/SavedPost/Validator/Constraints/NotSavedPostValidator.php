<?php

namespace App\Form\SavedPost\Validator\Constraints;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\SavedPost\SavedPostRepositoryInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotSavedPostValidator extends ConstraintValidator
{
    public SavedPostRepositoryInterface $savedPostRepository;

    public function __construct(SavedPostRepositoryInterface $savedPostRepository)
    {
        $this->savedPostRepository = $savedPostRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $savedPost = $this->savedPostRepository->getByPostIdUserId(new Uuid($value), $constraint->userId);

        if (!$savedPost) {
            return;
        }

        $this->context->buildViolation('The post is already saved')->addViolation();
    }
}
