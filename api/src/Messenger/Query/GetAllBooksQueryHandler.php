<?php

declare(strict_types=1);

namespace App\Messenger\Query;

use App\Dto\BookResponseDto;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllBooksQueryHandler
{
    public function __construct(
        private readonly BookRepository $bookRepository
    ) {
    }

    /**
     * @return array<BookResponseDto>
     */
    public function __invoke(GetAllBooksQuery $query): array
    {
        return array_map(
            static fn (Book $book): BookResponseDto => BookResponseDto::fromEntity($book),
            $this->bookRepository->findAll(),
        );
    }
}
