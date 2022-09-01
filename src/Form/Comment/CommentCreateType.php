<?php

declare(strict_types=1);

namespace App\Form\Comment;

use App\Entity\User;
use Symfony\Component\Uid;
use App\DTO\Comment\CreateComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\DataTransformerInterface;
use App\Form\Comment\Validator\Constraints\PostExist;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentCreateType extends AbstractType implements DataTransformerInterface
{
    private ?Uid\Uuid $commentId;
    private ?User $user;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->commentId = $options['commentId'];
        $this->user = $options['user'];

        $builder->add(
            'content',
            TextType::class,
            [
                'constraints' => [
                    new Length(['max' => 255]),
                    new NotBlank(),
                ]
            ]
        );

        $builder->add(
            'postId',
            TextType::class,
            [
                'constraints' => [
                    new Uuid(),
                    new NotBlank(),
                    new PostExist(),
                ]
            ]
        );

        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('commentId', null);
        $resolver->setDefault('user', null);
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function transform($value): ?array
    {
        return $value;
    }

    public function reverseTransform($value): ?CreateComment
    {
        if (
            null === $value['content'] ||
            null === $value['postId']
        ) {
            return null;
        }

        return new CreateComment($this->commentId, $value['content'], $this->user, $value['postId']);
    }
}
