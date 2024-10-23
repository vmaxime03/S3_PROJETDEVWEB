<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\db\DeefyRepository;

class AuthProvider
{
    public static function signin(string $user, string $password) : void {
        $repo = DeefyRepository::getInstance();
        $hash = $repo->findUserByEmail($user)->passwd;

        if (!password_verify($password, $hash))
            throw new AuthException("Auth error : invalid credentials");




    }
    public static function register( string $email, string $pass): void {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new AuthException(" error : invalid user email");

        $hash = password_hash($pass, PASSWORD_BCRYPT, ['cost'=>12]);

        //TODO "insert into User (email, passwd ) values($email, $hash)";
    }

}