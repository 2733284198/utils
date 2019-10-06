<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE.md
 */

namespace Hyperf\Utils\Serializer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function get_class;
use function is_scalar;

class ScalarNormalizer implements NormalizerInterface, DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return get_class($this) === __CLASS__;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        switch ($class) {
            case 'int':
                return (int) $data;
            case 'string':
                return (string) $data;
            case 'float':
                return (float) $data;
            case 'bool':
                return (bool) $data;
            default:
                return $data;
        }
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return in_array($type, [
            'int',
            'string',
            'float',
            'bool',
            'mixed',
        ]);
    }

    public function normalize($object, $format = null, array $context = [])
    {
        return $object;
    }

    public function supportsNormalization($data, $format = null)
    {
        return is_scalar($data);
    }
}
