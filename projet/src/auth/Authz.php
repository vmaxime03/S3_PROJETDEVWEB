<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\db\DeefyRepository;

class Authz
{
    public static function getPlaylistAuthz(int $plid) : bool {
        try {
            $user = AuthProvider::getSignedInUser();
        } catch (AuthException $exception) {
            return false;
        }
        $repo = DeefyRepository::getInstance();

        $owner = $repo->getPlaylistOwner($plid);
        if ($owner->id == $user->id) {
            return true;
        } else if ($repo->getUserRole($owner->id) > $user->role) {
            return true;
        }
        return false;



    }
}