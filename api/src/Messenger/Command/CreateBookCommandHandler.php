<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Entity\Book;
use App\Messenger\Message\BookAddedMessage;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
readonly class CreateBookCommandHandler
{
    public function __construct(
        private AuthorRepository $authorRepository,
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(CreateBookCommand $command): Book
    {
        $author = $this->authorRepository->find($command->getBookData()->getAuthor());
        $book = new Book();
        $book->setAuthor($author);
        $book->setTitle($command->getBookData()->getTitle());
        if (null !== $command->getBookData()->getIsbn()) {
            $book->setIsbn($command->getBookData()->getIsbn());
        }

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $this->entityManager->refresh($book);

        $this->messageBus->dispatch(new BookAddedMessage($book->getId()->toRfc4122()));

        return $book;
    }
}
