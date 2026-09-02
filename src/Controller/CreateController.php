<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Connection;


class CreateController
{
    #[Route('/thought', methods: ['POST'])]
    public function createThought(Connection $connection, Request $request): JsonResponse
    {
        // read user param in API Body
        $new_thought = $request->request->get('thoughtText');

        $affectedRows = $connection->executeStatement(
            'INSERT INTO Thoughts (thought) VALUES (?)',
            [$new_thought]
        );

        if ($affectedRows > 0) {
            return new JsonResponse(
                ['message' => 'Thought created successfully'],
                Response::HTTP_CREATED // 201
            );
        }

        return new JsonResponse(
            ['error' => 'Insert failed unexpectedly'],
            Response::HTTP_INTERNAL_SERVER_ERROR // 500
        );
    }
}