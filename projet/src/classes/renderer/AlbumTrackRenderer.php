<?php

namespace iutnc\deefy\renderer;

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;

class AlbumTrackRenderer extends AudioTrackRenderer
{
    private AlbumTrack $albumTrack;

    public function __construct(AlbumTrack $albumTrack) {
        $this->albumTrack = $albumTrack;
    }

    public function renderCompact() : string
    {
        return "<figure>
                  <figcaption>". $this->albumTrack->titre . " par ". $this->albumTrack->artiste .":</figcaption>
                  <audio controls src=". $this->albumTrack->path ."></audio> 
                </figure>";
    }
    public function renderLong() : string
    {
        return "<div>"."<p>" .
                "<b>" .  $this->albumTrack->titre . "</b>" . " par ". $this->albumTrack->artiste . " - " . $this->albumTrack->annee ."<br>" .
               "Dans " . $this->albumTrack->album . " (".$this->albumTrack->numero .")". "<br>" .
                AudioTrack::genreAsString($this->albumTrack->genre) . " - " . $this->albumTrack->duree . "</p>" .
                "<audio controls src=". $this->albumTrack->path ."></audio>" . "</div>";
    }

}