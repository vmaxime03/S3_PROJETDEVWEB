<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\db\DeefyRepository;

class AuthProvider
{
    public static function signin(string $user, string $password) : void {
        $repo = DeefyRepository::getInstance();
        $hash = $repo->findUserByEmail($_POST['userEmail'])->passwd;

        if (!password_verify($_POST['userPasswd'], $hash))
            throw new AuthException("Auth error : invalid credentials");


    }

    public static function getSignedInUser() : void {
        if (!(isset($_SESSION["userEmail"]) && $_SESSION["userEmail"] == $_POST['userEmail'])) {
            throw new AuthException("User not connected");
        }

    }


    public static function register( string $email, string $pass): void {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new AuthException(" error : invalid user email");

        $hash = password_hash($pass, PASSWORD_BCRYPT, ['cost'=>12]);

        //TODO "insert into User (email, passwd ) values($email, $hash)";
    }



}