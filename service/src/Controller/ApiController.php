<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\BookResponseDto;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    /**
     * @return array<BookResponseDto>
     */
    #[Route('/action', name: 'log_action', methods: ['POST'])]
    public function listBooks(Request $request, LoggerInterface $logger): Response
    {
        $content = json_decode($request->getContent(), true);
        $logger->info('action_called', ['payload' => $content]);

        return $this->json(['action' => $content['action'] ?? 'no_action_provided']);
    }
}