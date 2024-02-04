<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Dto\BookRequestDto;

readonly class CreateBookCommand
{
    public function __construct(
        private BookRequestDto $bookData,
    ) {
    }

    public function getBookData(): BookRequestDto
    {
        return $this->bookData;
    }
}
