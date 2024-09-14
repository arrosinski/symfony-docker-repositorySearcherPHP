<?php

namespace App\Tests\DTO;

use App\DTO\CodeSearchResultDTO;
use PHPUnit\Framework\TestCase;

class CodeSearchResultDTOTest extends TestCase
{
    public function testCodeSearchResultDTO()
    {
        $dto = new CodeSearchResultDTO('owner', 'repo', 'file', 10.0);

        $this->assertEquals('owner', $dto->getOwnerName());
        $this->assertEquals('repo', $dto->getRepoName());
        $this->assertEquals('file', $dto->getFileName());
        $this->assertEquals(10.0, $dto->getScore());
    }
}
