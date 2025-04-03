<?php

declare(strict_types=1);

namespace App\Tests\Unit\Form\DataTransformer;

use App\Form\DataTransformer\CityNameTransformer;
use PHPUnit\Framework\TestCase;

class CityNameTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $transformer = new CityNameTransformer();

        self::assertSame('', $transformer->transform(null));
        self::assertSame('Kozy', $transformer->transform('Kozy'));
    }

    public function testReverseTransform(): void
    {
        $transformer = new CityNameTransformer();

        self::assertSame('', $transformer->reverseTransform(null));
        self::assertSame('Kozy', $transformer->reverseTransform('kozy'));
        self::assertSame('Kozy', $transformer->reverseTransform('KOZY'));
    }
}
