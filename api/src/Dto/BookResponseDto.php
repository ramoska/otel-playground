<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Book;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class BookResponseDto
{
    public function __construct(
        #[SerializedName('id')]
        private string $id,
        #[SerializedName('title')]
        private string $title,
        #[SerializedName('isbn')]
        private ?string $isbn,
        #[SerializedName('author')]
        private AuthorResponseDto $author,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function getAuthor(): AuthorResponseDto
    {
        return $this->author;
    }

    public static function fromEntity(Book $book): self
    {
        return new self(
            id: $book->getId()->toRfc4122(),
            title: $book->getTitle(),
            isbn: $book->getIsbn(),
            author: AuthorResponseDto::fromEntity($book->getAuthor()),
        );
    }
}
