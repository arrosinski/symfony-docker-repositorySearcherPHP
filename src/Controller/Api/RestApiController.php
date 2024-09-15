<?php

// src/Controller/Api/RestApiController.php
namespace App\Controller\Api;

use App\SearchInRepo\GithubSearchCodeInRepoStrategy;
use App\Service\Api\SearchCodeInRepoService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RestApiController
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    #[Route('/api/v1/code/search', methods: ['GET'])]
    #[OA\Get(
        path: '/api/v1/code/search',
        summary: 'Search code in repository',
        parameters: [
            new OA\Parameter(
                name: 'code',
                in: 'query',
                description: 'Code to search for',
                required: true,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                description: 'Page number',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'per_page',
                in: 'query',
                description: 'Number of results per page',
                required: false,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'items',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                properties: [
                                    new OA\Property(property: 'repository', type: 'object', properties: [
                                        new OA\Property(property: 'owner', type: 'object', properties: [
                                            new OA\Property(property: 'login', type: 'string')
                                        ])
                                    ]),
                                    new OA\Property(property: 'name', type: 'string'),
                                    new OA\Property(property: 'score', type: 'number', format: 'float')
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    #[Security(name: 'Bearer')]
    public function searchCodeInRepo(Request $request): JsonResponse
    {
        $searchInCodeReposeService = new SearchCodeInRepoService(new GithubSearchCodeInRepoStrategy());

        $code = htmlspecialchars($request->get('code'), ENT_QUOTES, 'UTF-8');
        $page = htmlspecialchars($request->get('page'), ENT_QUOTES, 'UTF-8');
        $perPage = htmlspecialchars($request->get('per_page'), ENT_QUOTES, 'UTF-8');

        return $searchInCodeReposeService->searchCodeInRepo($code, $page, $perPage);
    }
}
