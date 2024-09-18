<?php

namespace App\Controller\Api;

use App\Exception\InvalidSearchQueryException;
use App\Service\Api\SearchCodeInRepoService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RestApiController
{
    private SearchCodeInRepoService $searchCodeInRepoService;

    public function __construct(SearchCodeInRepoService $searchCodeInRepoService)
    {
        $this->searchCodeInRepoService = $searchCodeInRepoService;
    }

    public function searchCodeInRepo(Request $request): JsonResponse
    {
        try {
            $code = htmlspecialchars($request->get('code'), ENT_QUOTES, 'UTF-8');
            $page = htmlspecialchars($request->get('page'), ENT_QUOTES, 'UTF-8');
            $perPage = htmlspecialchars($request->get('per_page'), ENT_QUOTES, 'UTF-8');

            return $this->searchCodeInRepoService->searchCodeInRepo($code, $page, $perPage);
        } catch (InvalidSearchQueryException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
