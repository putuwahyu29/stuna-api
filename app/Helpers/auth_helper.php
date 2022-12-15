<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) {
        throw new Exception('Missing or invalid JWT in request');
    }
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = 'secret';
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $userModel = new UserModel();
    $userModel->findUserByUserName($decodedToken->username);
}

function getSignedJWTForUser(string $username)
{
    $payload = [
        'username' => $username,
        'iat' => 1356999524,
        'nbf' => 1357000000
    ];
    // $key = Services::getSecretKey();
    $key = 'secret';
    $jwt = JWT::encode($payload,  $key, 'HS256');
    return $jwt;
}
