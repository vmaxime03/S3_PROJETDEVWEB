<?php

namespace iutnc\deefy\renderer;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\const\Consts;

class PodcastTrackRenderer implements Renderer
{
    private PodcastTrack $podcastTrack;

    public function __construct(PodcastTrack $podcastTrack) {
        $this->podcastTrack = $podcastTrack;
    }

    public function render(): string
    {
        $audiopath = Consts::UPLOAD_URL . "/" . $this->podcastTrack->filename;
        return <<<HTML
            <figure class="track"><p>
            <b> {$this->podcastTrack->titre} </b> par {$this->podcastTrack->auteur} - {$this->podcastTrack->date}<br>
            {$this->podcastTrack->genre} - {$this->podcastTrack->duree}</p>
            <audio controls src={$audiopath}></audio>
            </figure>
HTML;

    }
}