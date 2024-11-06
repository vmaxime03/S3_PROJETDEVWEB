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

        $ownerId = $repo->getPlaylistOwnerId($plid);
        if ($ownerId == $user->id) {
            return true;
        } else if ($repo->getUserById($ownerId)->role < $user->role) {
            return true;
        }
        return false;
    }
}