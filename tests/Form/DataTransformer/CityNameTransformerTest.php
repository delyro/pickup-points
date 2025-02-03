<?php

declare(strict_types=1);

namespace App\Tests\Form\DataTransformer;

use App\Form\DataTransformer\CityNameTransformer;
use PHPUnit\Framework\TestCase;

class CityNameTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $transformer = new CityNameTransformer();

        $this->assertSame('', $transformer->transform(null));
        $this->assertSame('Kozy', $transformer->transform('Kozy'));
    }

    public function testReverseTransform(): void
    {
        $transformer = new CityNameTransformer();

        $this->assertSame('', $transformer->reverseTransform(null));
        $this->assertSame('Kozy', $transformer->reverseTransform('kozy'));
        $this->assertSame('Kozy', $transformer->reverseTransform('KOZY'));
    }
}
