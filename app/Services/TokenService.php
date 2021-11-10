<?php


namespace App\Services;


use Tymon\JWTAuth\Contracts\JWTSubject;

class TokenService
{

    private function generateToken(JWTSubject $subject, string $type, string $ttl)
    {
        auth()->setTTL(config($ttl));
        auth()->claims(['typ' => $type]);
        return auth()->fromUser($subject);
    }

    public function generateAccessToken(JWTSubject $subject)
    {
        return $this->generateToken($subject, 'access', 'jwt.ttl');
    }

    public function generateTokens(JWTSubject $subject): array
    {
        return array(
            'access' => $this->generateAccessToken($subject),
            'refresh' => $this->generateToken($subject, 'refresh', 'jwt.refresh_ttl'));
    }

    public function invalidateToken()
    {
        return auth()->manager()->invalidate(auth()->parseToken()->getToken());
    }

    public function validateToken($token)
    {
        return auth()->check($token);
    }

}
