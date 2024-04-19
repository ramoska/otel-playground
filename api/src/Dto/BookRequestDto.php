<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BookRequestDto
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Uuid()]
        private readonly string $author,
        #[Assert\NotBlank()]
        #[Assert\Length(min: 1, max: 255)]
        private readonly string $title,
        #[Assert\Isbn()]
        private readonly ?string $isbn,
    ) {
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }
}
