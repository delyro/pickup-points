<?php

declare(strict_types=1);

namespace App\External\Easypack;

final class Configuration
{
    private string $easyPackBaseUrl;

    public function __construct(string $easyPackBaseUrl)
    {
        $this->easyPackBaseUrl = $easyPackBaseUrl;
    }

    public function getBaseUrl(): BaseUrl
    {
        return BaseUrl::fromString($this->easyPackBaseUrl);
    }
}
