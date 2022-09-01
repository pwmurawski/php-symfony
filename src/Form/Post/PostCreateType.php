<?php

declare(strict_types=1);

namespace App\Form\Post;

use App\Entity\User;
use App\DTO\Post\CreatePost;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostCreateType extends AbstractType implements DataTransformerInterface
{
    private ?Uuid $postId;
    private ?User $user;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->postId = $options['postId'];
        $this->user = $options['user'];

        $builder->add(
            'title',
            TextType::class,
            [
                'constraints' => [
                    new Length(['max' => 255]),
                    new NotBlank(),
                ]
            ]
        );

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
        $resolver->setDefault('postId', null);
        $resolver->setDefault('user', null);
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function transform($value): ?array
    {
        return $value;
    }

    public function reverseTransform($value): ?CreatePost
    {
        if (
            null === $value['title'] ||
            null === $value['content']
        ) {
            return null;
        }

        return new CreatePost($this->postId, $value['title'], $value['content'], $this->user);
    }
}
