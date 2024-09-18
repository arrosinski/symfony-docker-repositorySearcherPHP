<?php

namespace App\Controller\Api;

use App\SearchInRepo\GithubSearchCodeInRepoStrategy;
use App\Service\Api\SearchCodeInRepoService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RestApiController
{
    private SearchCodeInRepoService $searchCodeInRepoService;

    public function __construct(SearchCodeInRepoService $searchCodeInRepoService)
    {
        $this->searchCodeInRepoService = $searchCodeInRepoService;
    }

    public function searchCodeInRepo(Request $request): JsonResponse
    {
        $code = htmlspecialchars($request->get('code'), ENT_QUOTES, 'UTF-8');
        $page = htmlspecialchars($request->get('page'), ENT_QUOTES, 'UTF-8');
        $perPage = htmlspecialchars($request->get('per_page'), ENT_QUOTES, 'UTF-8');

        return $this->searchCodeInRepoService->searchCodeInRepo($code, $page, $perPage);
    }
}
