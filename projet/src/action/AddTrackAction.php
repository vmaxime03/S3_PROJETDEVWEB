<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AlbumTrack;



class AddTrackAction extends Action
{
    private const UPLOAD_URL = "http://localhost/BUT/S3_PROJETDEVWEB/projet/uploads/audio";
    private const AUDIO_PATH =  __DIR__ . "\\..\\..\\uploads\\audio";

    public function get(): string
    {
        return <<<END
<form action="?action=add-track" enctype="multipart/form-data" method="POST">
    <input type="text" name="trackTitre" placeholder="titre">
    <input type="text" name="trackGenre" placeholder="genre">
    <input type="number" name="trackDuree" placeholder="duree">
    <select name="trackType">
        <option value="album">Album track</option>
        <option value="podcast">Podcast track</option>
    </select>
    <br>
    <label>album track :</label>
    <input type="text" name="trackArtisteAlbum" placeholder="artiste album">
    <input type="text" name="trackTitreAlbum" placeholder="titre album">
    <input type="number" min="1900" max="2100" step="1" value="2024" name="trackAnneeAlbum" placeholder="annee album">
    <input type="number" name="trackNumeroAlbum" placeholder="numero album">
    <br>
    <label>podcast track :</label>
    <input type="text" name="trackAuteurPodcast" placeholder="auteur podcast">
    <input type="date" name="trackDatePodcast" placeholder="date podcast">
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