<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\db\DeefyRepository;
use iutnc\deefy\renderer\RendererFactory;

class DisplayPlaylistAction extends Action
{

    public function get(): string
    {
        $repo = DeefyRepository::getInstance();



        if (isset($_SESSION['playlist'])) {

            if (isset($_GET["plid"])&& $_GET["plid"] == filter_var($_GET["plid"], FILTER_VALIDATE_INT)) {
                $plid = $_GET["plid"];
            } else {
                $plid = $_SESSION['playlist'];
            }

            $html = "<h1>" .  $repo->getPlaylist($plid)->nom . "</h1><br>";
            $tracks = $repo->getPlaylistTracks($plid);

            foreach ($tracks as $track) {
                switch ($track->getType()) {
                    case 'album' :
                        $t = new AlbumTrack($track->titre, $track->genre, $track->duree, $track->filename, $track->artiste_album,
                                            $track->titre_album, $track->annee_album, $track->numero_album);
                        break;
                    case 'podcast' :
                        $t = new PodcastTrack($track->titre, $track->genre, $track->duree, $track->filename, $track->auteur_podcast,
                            $track->date_posdcast);
                        break;
                        default :
                            //TODO
                            throw new \Exception();
                }
                $html .= RendererFactory::getRenderer($t)->render();
            }


            return $html;
        }
        else
            return "pas de playlist";
    }

    public function post(): string
    {
        return "POST display playlist";
    }
}