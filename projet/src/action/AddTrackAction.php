<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\const\Consts;
use iutnc\deefy\db\DeefyRepository;
use iutnc\deefy\renderer\RendererFactory;


class AddTrackAction extends Action
{


    public function get(): string
    {
        if (isset($_GET["plid"])&& $_GET["plid"] == filter_var($_GET["plid"], FILTER_VALIDATE_INT)) {
            $plid = $_GET["plid"];
        } else {
            if (!isset($_SESSION['playlist'])) return "No existing playlist";
            else $plid = $_SESSION['playlist'];
        }
        if (!Authz::getPlaylistAuthz($plid)) {
            return "vous n'avez pas le droit";
        }
        return <<<END
<form action="?action=add-track&plid=$plid" enctype="multipart/form-data" method="POST">
    <input type="text" name="trackTitre" placeholder="titre">
    <input type="text" name="trackGenre" placeholder="genre">
    <input type="number" name="trackDuree" placeholder="duree">
    <select name="trackType">
        <option value="A">Album track</option>
        <option value="P">Podcast track</option>
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
        if (isset($_GET["plid"])&& $_GET["plid"] == filter_var($_GET["plid"], FILTER_VALIDATE_INT)) {
            $plid = $_GET["plid"];
        } else {
            if (isset($_SESSION['playlist'])) {
                $plid = $_SESSION['playlist'];
            }
            else
                return "pas de playlist";
        }
        if (!Authz::getPlaylistAuthz($plid)) {
            return "vous n'avez pas le droit";
        }


        if (!($_POST['trackTitre'] === filter_var($_POST["trackTitre"]) &&
            $_POST['trackGenre'] === filter_var($_POST["trackGenre"]) &&
            $_POST['trackDuree'] === filter_var($_POST["trackDuree"]) &&
            $_POST['trackType'] === filter_var($_POST["trackType"]) &&
            $_POST['trackArtisteAlbum'] === filter_var($_POST["trackArtisteAlbum"]) &&
            $_POST['trackTitreAlbum'] === filter_var($_POST["trackTitreAlbum"]) &&
            $_POST['trackAnneeAlbum'] === filter_var($_POST["trackAnneeAlbum"]) &&
            $_POST['trackNumeroAlbum'] === filter_var($_POST["trackNumeroAlbum"]) &&
            $_POST['trackAuteurPodcast'] === filter_var($_POST["trackAuteurPodcast"]) &&
            $_POST['trackDatePodcast'] === filter_var($_POST["trackDatePodcast"]))) {
            return "erreur entrée invalide";
        }

        if ($_FILES['trackFile']['error'] !== UPLOAD_ERR_OK || $_FILES['trackFile']['type'] !== "audio/mpeg") {
            return "erreur fichier audio, track non enregistrée";
        }

        $filename = uniqid() . "." . pathinfo($_FILES['trackFile']['name'], PATHINFO_EXTENSION);


        if ($_POST['trackType'] === "P") {
            $track = new PodcastTrack($_POST["trackTitre"],$_POST["trackGenre"],$_POST["trackDuree"],
                                    $filename,$_POST["trackAuteurPodcast"],$_POST["trackDatePodcast"]);
        } else if ($_POST['trackType'] === "A") {
            $track = new AlbumTrack($_POST["trackTitre"],$_POST["trackGenre"],$_POST["trackDuree"],
                                    $filename, $_POST["trackArtisteAlbum"], $_POST["trackTitreAlbum"],
                                    $_POST["trackAnneeAlbum"], $_POST["trackNumeroAlbum"]);
        } else {
            return "mauvais track type";
        }

        $repo = DeefyRepository::getInstance();

        $repo->addTrackToPlaylist($track, $plid, 1);

        $dest = Consts::AUDIO_PATH . "\\" . $filename ;

        move_uploaded_file($_FILES['trackFile']["tmp_name"], $dest);

        return "added custom track <br>" . RendererFactory::getRenderer($track)->render() ;
    }
}