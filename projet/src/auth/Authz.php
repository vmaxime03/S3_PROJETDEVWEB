<?php

namespace iutnc\deefy\auth;

class Authz
{
    public static function getPlaylistAuthz(int $plid) : boolean {
        try {
            $user = AuthProvider::getSignedInUser();
        } catch (AuthException $exception) {
            return false;
        }


    }
}