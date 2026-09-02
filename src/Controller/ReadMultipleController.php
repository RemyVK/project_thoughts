<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Connection;


class ReadMultipleController
{
    #[Route('/thoughts', methods: ['GET'])]
    public function getMultipleThoughts(Connection $connection, Request $request): JsonResponse
    {
        $page_number = $request->query->get('PageNumber');
        $page_size = $request->query->get('PageSize');
        $offset_count = ($page_number - 1) * $page_size;

        $many_thoughts = $connection->fetchAllAssociative("SELECT thought, created_at FROM Thoughts ORDER BY created_at DESC LIMIT $page_size OFFSET $offset_count");

        return new JsonResponse(
            $many_thoughts
        );
    }
}