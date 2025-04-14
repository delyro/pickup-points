<?php

declare(strict_types=1);

namespace App\External\Easypack;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface EasypackClientInterface
{
    public function get(string $resource, array $queryData): ResponseInterface;
}
