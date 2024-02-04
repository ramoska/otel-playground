<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\BookRequestDto;
use App\Dto\BookResponseDto;
use App\Messenger\Command\CreateBookCommand;
use App\Messenger\Query\GetAllBooksQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    /**
     * @return array<BookResponseDto>
     */
    #[Route('/books', name: 'list_books', methods: ['GET'])]
    public function listBooks(MessageBusInterface $queryBus): Response
    {
        return $this->json($queryBus->dispatch(new GetAllBooksQuery())->last(HandledStamp::class)->getResult());
    }

    #[Route('/books', name: 'create_book', methods: ['POST'])]
    public function createBook(
        #[MapRequestPayload]
        BookRequestDto $bookRequestDto,
        MessageBusInterface $commandBus,
    ): Response {
        $book = $commandBus->dispatch(new CreateBookCommand($bookRequestDto))->last(HandledStamp::class)->getResult();
        return $this->json(BookResponseDto::fromEntity($book), Response::HTTP_CREATED);
    }
}
