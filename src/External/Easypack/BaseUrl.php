<?php

declare(strict_types=1);

namespace App\External\Easypack;

use Webmozart\Assert\Assert;

final class BaseUrl
{
    private string $baseUrl;

    private function __construct(string $baseUrl)
    {
        Assert::regex($baseUrl, '#^http(s)?://.+#');
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public static function fromString(string $string): self
    {
        return new self($string);
    }

    public function asString(): string
    {
        return $this->baseUrl;
    }
}
