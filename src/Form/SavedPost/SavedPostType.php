<?php

declare(strict_types=1);

namespace App\Form\SavedPost;

use Symfony\Component\Uid\Uuid;
use App\DTO\SavedPost\CreateSavedPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\DataTransformerInterface;
use App\Form\Comment\Validator\Constraints\PostExist;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\SavedPost\Validator\Constraints\NotSavedPost;

class SavedPostType extends AbstractType implements DataTransformerInterface
{
    private ?Uuid $savedPostId;
    private ?Uuid $userId;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->savedPostId = $options['savedPostId'];
        $this->userId = $options['userId'];

        $builder->add(
            'postId',
            TextType::class,
            [
                'constraints' => [
                    new Length(['max' => 255]),
                    new NotBlank(),
                    new PostExist(),
                    new NotSavedPost($this->userId),
                ]
            ]
        );

        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('savedPostId', null);
        $resolver->setDefault('userId', null);
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function transform($value): ?array
    {
        return $value;
    }

    public function reverseTransform($value): ?CreateSavedPost
    {
        if (
            null === $value['postId']
        ) {
            return null;
        }

        return new CreateSavedPost($this->savedPostId, $this->userId, $value['postId']);
    }
}
