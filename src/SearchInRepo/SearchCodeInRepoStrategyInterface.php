<?php

namespace App\SearchInRepo;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\InvalidSearchQueryException;

interface SearchCodeInRepoStrategyInterface
{
    /**
     * @throws InvalidSearchQueryException
     */
    public function searchCodeInRepo(string $code, string $page, string $perPage): JsonResponse;
}
