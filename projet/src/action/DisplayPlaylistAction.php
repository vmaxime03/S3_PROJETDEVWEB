<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\db\DeefyRepository;
use iutnc\deefy\renderer\RendererFactory;

class DisplayPlaylistAction extends Action
{

    public function get(): string
    {
        $repo = DeefyRepository::getInstance();

        if (isset($_GET["plid"])&& $_GET["plid"] == filter_var($_GET["plid"], FILTER_VALIDATE_INT)) {
            $plid = $_GET["plid"];
        } else {
            if (isset($_SESSION['playlist'])) {

                $plid = $_SESSION['playlist'];
            } else {
                return "pas de playlist";
            }
        }

        if (!Authz::getPlaylistAuthz($plid)) {
            return "vous n'avez pas le droit";
        }

        $html = "<h1>" .  $repo->getPlaylist($plid)->nom . "</h1><br>".
                "<a href='?action=add-track&plid=$plid'>Ajouter track a la playlist</a>";

        $tracks = $repo->getPlaylistTracks($plid);

        foreach ($tracks as $track) {
            switch ($track->type) {
                case 'A' :
                    $t = new AlbumTrack($track->titre, $track->genre, $track->duree, $track->filename, $track->artiste_album,
                        $track->titre_album, $track->annee_album, $track->numero_album);
                    break;
                case 'P' :
                    $t = new PodcastTrack($track->titre, $track->genre, $track->duree, $track->filename, $track->auteur_podcast,
                        $track->date_posdcast);
                    break;
                default :
                    return "erreur type track";
                    throw new \Exception();
            }
            $html .= RendererFactory::getRenderer($t)->render() . "<br>";
        }


        return $html;

    }

    public function post(): string
    {
        return "POST display playlist";
    }
}