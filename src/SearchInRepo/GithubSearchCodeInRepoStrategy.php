<?php

namespace App\SearchInRepo;

use App\DTO\CodeSearchResultDTOCollection;
use App\DTO\CodeSearchResultDTO;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubSearchCodeInRepoStrategy implements SearchCodeInRepoStrategyInterface
{
    private const GITHUB_API_URL = 'https://api.github.com/search/code?q=';

    public function __construct(private HttpClientInterface $client, private string $githubApiToken)
    {
        $this->client = HttpClient::create(
            ['headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'Symfony',
                'Authorization' => 'token ' . $this->githubApiToken
            ]]
        );
    }

    public function setHttpClient(HttpClientInterface $client): void
    {
        $this->client = $client;
    }

    public function searchCodeInRepo(string $code, string $page, string $perPage): JsonResponse
    {
        $response = $this->client->request('GET', self::GITHUB_API_URL . $code . '&page=' . $page . '&per_page=' . $perPage);
        $data = $response->toArray();

        $collection = new CodeSearchResultDTOCollection();
        foreach ($data['items'] as $item) {
            $dto = $this->createCodeSearchResultDTO($item);
            $collection->add($dto);
        }

        return new JsonResponse($collection->toArray());
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
