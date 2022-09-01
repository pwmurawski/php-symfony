<?php

declare(strict_types=1);

namespace App\Form\Comment;

use App\Entity\User;
use Symfony\Component\Uid;
use App\DTO\Comment\PutComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentPutType extends AbstractType implements DataTransformerInterface
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

    public function reverseTransform($value): ?PutComment
    {
        if (
            null === $value['content']
        ) {
            return null;
        }

        return new PutComment($this->commentId, $this->user, $value['content']);
    }
}
