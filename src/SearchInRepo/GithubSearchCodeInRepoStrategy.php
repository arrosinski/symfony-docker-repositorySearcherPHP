<?php

namespace App\SearchInRepo;

use App\DTO\CodeSearchResultDTOCollection;
use App\DTO\CodeSearchResultDTO;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class GithubSearchCodeInRepoStrategy implements SearchCodeInRepoStrategyInterface
{
    const GITHUB_API_URL = 'https://api.github.com/search/code?q=';

    public function __construct()
    {
    }

    public function searchCodeInRepo(string $code, string $page, string $perPage, string $sortBy = 'score'): JsonResponse
    {
        $client = HttpClient::create(
            ['headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'Symfony',
                'Authorization' => 'token ' . $_ENV['GITHUB_API_TOKEN']
            ]]
        );

        $codeSearchResultsCollection = new CodeSearchResultDTOCollection();
        $response = $client->request('GET', self::GITHUB_API_URL . $code . '&page=' . (int)$page . '&per_page=' . (int)$perPage);

        foreach ($response->toArray()['items'] as $item) {
            $codeSearchResultsCollection->add($this->createCodeSearchResultDTO($item));
        }

        $codeSearchResultsCollection->sortBy($sortBy);

        return new JsonResponse($codeSearchResultsCollection->toArray());
    }

    private function createCodeSearchResultDTO(array $item): CodeSearchResultDTO
    {
        return new CodeSearchResultDTO(
            $item['repository']['owner']['login'],
            $item['repository']['name'],
            $item['name'],
            $item['score']
        );
    }
}
