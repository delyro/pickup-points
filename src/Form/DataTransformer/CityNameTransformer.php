<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class CityNameTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): string
    {
        return $value ?? '';
    }

    public function reverseTransform(mixed $value): string
    {
        if (!$value) {
            return '';
        }

        return ucfirst(strtolower($value));
    }
}
