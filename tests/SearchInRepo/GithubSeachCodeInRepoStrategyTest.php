<?php

namespace App\Tests\SearchInRepo;

use App\SearchInRepo\GithubSearchCodeInRepoStrategy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class GithubSearchCodeInRepoStrategyTest extends TestCase
{
    public function testSearchCodeInRepo()
    {
        $mockResponse = new MockResponse(json_encode([
            'items' => [
                [
                    'repository' => [
                        'owner' => ['login' => 'owner1'],
                        'name' => 'repo1'
                    ],
                    'name' => 'file1',
                    'score' => 10.0
                ],
                [
                    'repository' => [
                        'owner' => ['login' => 'owner2'],
                        'name' => 'repo2'
                    ],
                    'name' => 'file2',
                    'score' => 20.0
                ]
            ]
        ]));

        $client = new MockHttpClient($mockResponse);
        $strategy = new GithubSearchCodeInRepoStrategy();
        $strategy->setHttpClient($client);

        $response = $strategy->searchCodeInRepo('test', '1', '10');
        $this->assertInstanceOf(JsonResponse::class, $response);

        $data = json_decode($response->getContent(), true);
        $this->assertCount(2, $data);
        $this->assertEquals('owner1', $data[0]['owner']);
        $this->assertEquals('repo1', $data[0]['repository']);
        $this->assertEquals('file1', $data[0]['file']);
        $this->assertEquals(10.0, $data[0]['score']);
    }
}
