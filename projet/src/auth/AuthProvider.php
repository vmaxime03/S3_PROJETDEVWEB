<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\dbclasses\User;
use iutnc\deefy\db\DeefyRepository;


class AuthProvider
{
    public static function signin(string $email, string $password) : void {
        $repo = DeefyRepository::getInstance();
        $user = $repo->findUserByEmail($email);
        //TODO ERROR
        $hash = $user->passwd;

        if (!password_verify($password, $hash)) {
            throw new AuthException("Auth error : invalid credentials");
        }
        else {
            $_SESSION['user'] = serialize($user);
        }
    }

    public static function getSignedInUser() : User {
        if (isset($_SESSION["user"])) {
            return unserialize($_SESSION["user"]);
        } else {
            throw new AuthException("User not connected");
        }
    }


    public static function register( string $email, string $pass): void {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new AuthException(" error : invalid user email");


        if(DeefyRepository::getInstance()->findUserByEmail($email) == null){
            $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost'=>12]);
            DeefyRepository::getInstance()->addUser($email, $hash);
        } else {
            throw new CreateUserException("user already exist");
        }




    }



}