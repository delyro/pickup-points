<?php

declare(strict_types=1);

namespace App\External\Easypack\Response;

use Symfony\Component\Serializer\Attribute\SerializedName;

class Response
{
    public int $count;

    public int $page;

    #[SerializedName('total_pages')]
    public int $totalPages;

    /** @var array<Item> */
    public array $items = [];
}
