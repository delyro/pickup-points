<?php

declare(strict_types=1);

namespace App\Service\Hasher;

interface HasherInterface
{
    public function hash(string $input): string;
}
