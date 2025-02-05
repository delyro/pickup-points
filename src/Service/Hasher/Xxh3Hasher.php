<?php

declare(strict_types=1);

namespace App\Service\Hasher;

class Xxh3Hasher implements HasherInterface
{
    public function hash(string $input): string
    {
        return hash('xxh3', $input);
    }
}
