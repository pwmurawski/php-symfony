<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    private ObjectNormalizer $objectNormalizer;

    public function __construct(
        ObjectNormalizer $objectNormalizer
    ) {
        $this->objectNormalizer = $objectNormalizer;
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|mixed|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $context['ignored_attributes'] = ['password', 'roles', 'userIdentifier'];

        return $this->objectNormalizer->normalize($object, $format, $context);
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof User;
    }
}
