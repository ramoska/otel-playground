<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $author = new Author();
        $author->setName('Edgar Allan Poe');
        $manager->persist($author);

        $book = new Book();
        $book->setTitle('The Raven')->setIsbn('9780486290720')->setAuthor($author);
        $manager->persist($book);

        $book = new Book();
        $book->setTitle('The Tell-Tale Heart')->setIsbn('9780871917720')->setAuthor($author);
        $manager->persist($book);

        $manager->flush();
    }
}
