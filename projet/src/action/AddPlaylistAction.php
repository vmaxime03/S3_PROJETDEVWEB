<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\playlist;
use iutnc\deefy\auth\AuthException;
use iutnc\deefy\auth\AuthProvider;
use iutnc\deefy\db\DeefyRepository;

class AddPlaylistAction extends Action
{

    public function get(): string
    {
        try {
            AuthProvider::getSignedInUser();
            return <<<END
<form action="?action=add-playlist" method="POST">
    <input type="text" name="playlistName" placeholder="Playlist Name">
    <input type="submit" value="Creer Playlist">
</form>

END;
        } catch (AuthException $e) {
            return "vous n'etes pas connecté";
        }


    }

    public function post(): string
    {
        if ($_POST["playlistName"] === filter_var($_POST["playlistName"], FILTER_SANITIZE_STRING)) {
            $pl = filter_var($_POST["playlistName"], FILTER_SANITIZE_STRING);
        }
        else {
            return "nom invalide";
        }

        $repo = DeefyRepository::getInstance();

        $_SESSION["playlist"] =  $repo->addPlaylistToUser($pl, unserialize($_SESSION["user"])->email);

        return "playliste added";

    }
}