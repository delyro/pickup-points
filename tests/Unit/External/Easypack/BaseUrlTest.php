<?php

namespace App\Tests\Unit\External\Easypack;

use App\External\Easypack\BaseUrl;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BaseUrlTest extends TestCase
{
    /**
     * @dataProvider invalidUrls
     */
    public function testRequiresAValidBaseUrlStartingWithHttpOrHttps(string $invalidUrl): void
    {
        self::expectException(InvalidArgumentException::class);

        BaseUrl::fromString($invalidUrl);
    }

    /**
     * @return array<array<string>>
     */
    public function invalidUrls(): array
    {
        return [
            ['htt://test'],
            ['httpsss://test'],
            ['http://'],
            ['https://'],
        ];
    }

    public function testStripsTrailingSlash(): void
    {
        self::assertEquals(
            'https://api-shipx-pl.easypack24.net/v1',
            BaseUrl::fromString('https://api-shipx-pl.easypack24.net/v1')->asString()
        );
    }
}
