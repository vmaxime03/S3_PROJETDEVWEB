<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AlbumTrack;



class AddTrackAction extends Action
{
    private const UPLOAD_URL = "http://localhost/BUT/S3_DEVWEB/td11/uploads/audio";
    private const AUDIO_PATH = "C:\\xampp\\htdocs\\BUT\\S3_DEVWEB\\td11\\uploads\\audio";

    public function get(): string
    {
        return <<<END
<form action="?action=add-track" enctype="multipart/form-data" method="POST">
    <input type="text" name="trackName" placeholder="Track Name">
    <input type="text" name="trackArtist" placeholder="Track Artist">
    <input type="text" name="trackAlbum" placeholder="Track Album">
    <br>
    <label>Audio :</label>
    <input type="file" name="trackFile" placeholder="null">
    <br>
    <input type="submit" value="Ajouter Track">
</form>
END;

    }

    public function post(): string
    {

        if (!isset($_SESSION['playlist'])) return "No existing playlist";

        if ($_FILES['trackFile']['error'] !== UPLOAD_ERR_OK || $_FILES['trackFile']['type'] !== "audio/mpeg") {
            return "erreur fichier audio, track non enregistrée";
        }

        $filename = uniqid() . "." . pathinfo($_FILES['trackFile']['name'], PATHINFO_EXTENSION);
        $dest = self::AUDIO_PATH . "\\" . $filename ;
        $src = self::UPLOAD_URL . "/" . $filename ;

        move_uploaded_file($_FILES['trackFile']["tmp_name"], $dest);

        $track = new AlbumTrack(filter_var($_POST["trackName"], FILTER_SANITIZE_STRING),
                            $src,
                            filter_var($_POST["trackAlbum"], FILTER_SANITIZE_STRING),
                            0);
        $track->__set("auteur", filter_var($_POST["trackArtist"], FILTER_SANITIZE_STRING));
        $_SESSION["playlist"]->addTrack($track);

        return "added custom track" ;
    }
}