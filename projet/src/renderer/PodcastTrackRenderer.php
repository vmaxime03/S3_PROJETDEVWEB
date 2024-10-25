<?php

namespace iutnc\deefy\renderer;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

class PodcastTrackRenderer extends AudioTrackRenderer
{
    private PodcastTrack $podcastTrack;

    public function __construct(PodcastTrack $podcastTrack) {
        $this->podcastTrack = $podcastTrack;
    }

    public function renderCompact() : string
    {

        return "<figure>
                  <figcaption>". $this->podcastTrack->titre . " par ". $this->podcastTrack->auteur .":</figcaption>
                  <audio controls src=". $this->podcastTrack->path ."></audio> 
                </figure>";
    }
    public function renderLong() : string
    {
        return "<div>"."<p>" .
            "<b>" .  $this->podcastTrack->titre . "</b>" . " par ". $this->podcastTrack->auteur . " - " . $this->podcastTrack->date ."<br>" .
            AudioTrack::genreAsString($this->podcastTrack->genre) . " - " . $this->podcastTrack->duree . "</p>" .
            "<audio controls src=". $this->podcastTrack->path ."></audio>" . "</div>";
    }


}