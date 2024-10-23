<?php

namespace iutnc\deefy\action;
use iutnc\deefy\audio\lists\playlist;

class AddPlaylistAction extends Action
{

    public function get(): string
    {
        return <<<END
<form action="?action=add-playlist" method="POST">
    <input type="text" name="playlistName" placeholder="Playlist Name">
    <input type="submit" value="Creer Playlist">
</form>

END;

    }

    public function post(): string
    {

        $_SESSION["playlist"] = new Playlist(filter_var($_POST["playlistName"], FILTER_SANITIZE_STRING));
        return "Playlist ajoutée : " . filter_var($_POST["playlistName"], FILTER_SANITIZE_STRING);
    }
}