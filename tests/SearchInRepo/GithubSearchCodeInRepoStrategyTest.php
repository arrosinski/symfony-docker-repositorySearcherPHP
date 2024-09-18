<?php

use App\SearchInRepo\GithubSearchCodeInRepoStrategy;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GithubSearchCodeInRepoStrategyTest extends TestCase
{
    public function testSearchCodeInRepo()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $httpClient->method('request')
            ->willReturn($response);

        $response->method('toArray')
            ->willReturn([
                'items' => [
                    [
                        'repository' => [
                            'owner' => ['login' => 'owner'],
                            'name' => 'repo'
                        ],
                        'name' => 'file',
                        'score' => 1.0
                    ]
                ]
            ]);

        $strategy = new GithubSearchCodeInRepoStrategy($httpClient, 'fake_token');
        $result = $strategy->searchCodeInRepo('example', '1', '10');

        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
