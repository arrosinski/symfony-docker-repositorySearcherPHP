<?php

namespace App\DTO;

class CodeSearchResultDTO
{
    private readonly string $ownerName;
    private readonly string $repoName;
    private readonly string $fileName;
    private readonly float $score;

    public function __construct(
        string $ownerName,
        string $repoName,
        string $fileName,
        float $score
    )
    {
        $this->ownerName = $ownerName;
        $this->repoName = $repoName;
        $this->fileName = $fileName;
        $this->score = $score;
    }

    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    public function getRepoName(): string
    {
        return $this->repoName;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getScore(): float
    {
        return $this->score;
    }
}
