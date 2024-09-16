<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTTokenManager
{
    private string $secretKey;
    private EntityManagerInterface $entityManager;

    public function __construct(string $secretKey, EntityManagerInterface $entityManager)
    {
        $this->secretKey = $secretKey;
        $this->entityManager = $entityManager;
    }

    public function decode(string $token): ?User
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $this->entityManager->getRepository(User::class)->findOneBy(['username' => $decoded->username]);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function encode(User $user): string
    {
        $payload = [
            'username' => $user->getUsername(),
            'exp' => (new \DateTime('+1 hour'))->getTimestamp(),
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }
}
