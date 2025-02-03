<?php

declare(strict_types=1);

namespace App\Form\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    #[
        Assert\NotBlank(),
        Assert\Length(min: 3, max: 64)
    ]
    public string $city;

    #[
        Assert\NotBlank(allowNull: true),
        Assert\Length(min: 3, max: 64)
    ]
    public ?string $street = null;

    #[
        Assert\When(
            expression: 'this.street !== null',
            constraints: [
                new Assert\NotBlank(),
                new Assert\Regex("/^\d{2}-\d{3}$/"),
            ]
        )
    ]
    public ?string $postalCode = null;
}
