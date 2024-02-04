<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use App\Repository\BookRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
class BookAddedMessageHandler
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly HttpClientInterface $serviceClient,
    ) {
    }

    public function __invoke(BookAddedMessage $message): void
    {
        $book = $this->bookRepository->find($message->getBookId());
        $this->serviceClient->request('POST', '/api/action', [
            'json' => [
                'action' => 'bookAdded',
                'bookData' => [
                    'id' => $message->getBookId(),
                    'title' => $book->getTitle(),
                    'author' => $book->getAuthor()->getName(),
                ],
            ],
        ]);
    }
}
