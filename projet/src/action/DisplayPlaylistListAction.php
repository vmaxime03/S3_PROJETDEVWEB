<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthException;
use iutnc\deefy\auth\AuthProvider;
use iutnc\deefy\db\DeefyRepository;

class DisplayPlaylistListAction extends Action
{

    public function get(): string
    {
        $repo = DeefyRepository::getInstance();

        try {
            $user = AuthProvider::getSignedInUser();
        } catch (AuthException $e) {
            return "pas connecté";
        }

        $pls = $repo->getUserPlaylists($user->id);

        $html  = "<div class='list'>";

        foreach ($pls as $pl) {
            $html .= "<li>" . $pl->nom . "</li>   <a href='?action=playlist&plid=$pl->id'>inspecter</a>";
        }

        return $html . "</div>";
    }

    public function post(): string
    {
        // TODO: Implement post() method.
    }
}