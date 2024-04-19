<?php

declare(strict_types=1);

namespace App\Messenger\Message;

class BookAddedMessage
{
    public function __construct(
        private string $bookId,
    ) {
    }

    public function getBookId(): string
    {
        return $this->bookId;
    }
}
