<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Author;
use Symfony\Component\Serializer\Attribute\SerializedName;

class AuthorResponseDto
{
    public function __construct(
        #[SerializedName('id')]
        private readonly string $id,
        #[SerializedName('name')]
        private readonly string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromEntity(Author $author): self
    {
        return new self(
            id: $author->getId()->toRfc4122(),
            name: $author->getName(),
        );
    }
}
