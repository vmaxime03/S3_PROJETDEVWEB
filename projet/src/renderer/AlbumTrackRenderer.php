<?php

namespace iutnc\deefy\renderer;

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\const\Consts;

class AlbumTrackRenderer implements Renderer
{
    private AlbumTrack $albumTrack;

    public function __construct(AlbumTrack $albumTrack) {
        $this->albumTrack = $albumTrack;
    }

    public function renderCompact() : string
    {
        return "<figure>
                  <figcaption>". $this->albumTrack->titre . " par ". $this->albumTrack->artiste .":</figcaption>
                  <audio controls src=". Consts::UPLOAD_URL . "/" . $this->albumTrack->filename ."></audio> 
                </figure>";
    }
    public function renderLong() : string
    {
        return "<div>"."<p>" .
                "<b>" .  $this->albumTrack->titre . "</b>" . " par ". $this->albumTrack->artiste . " - " . $this->albumTrack->annee ."<br>" .
               "Dans " . $this->albumTrack->album . " (".$this->albumTrack->numero .")". "<br>" .
                $this->albumTrack->genre . " - " . $this->albumTrack->duree . "</p>" .
                "<audio controls src=". $this->albumTrack->filename ."></audio>" . "</div>";
    }

    public function render(): string
    {
        return "<figure>
                  <figcaption>". $this->albumTrack->titre . " par ". $this->albumTrack->artiste .":</figcaption>
                  <audio controls src=". Consts::UPLOAD_URL . "/" .  $this->albumTrack->filename ."></audio> 
                </figure>";
    }
}