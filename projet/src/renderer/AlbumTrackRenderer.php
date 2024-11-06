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


    public function render(): string
    {
        $audiopath = Consts::UPLOAD_URL . "/" . $this->albumTrack->filename;
        return <<<HTML
            <figure class="track">
            <p><b> {$this->albumTrack->titre} </b> par {$this->albumTrack->artiste}, {$this->albumTrack->annee} <br>
            Dans {$this->albumTrack->album}  ({$this->albumTrack->numero})<br>
            {$this->albumTrack->genre} - {$this->albumTrack->duree} </p>
            <audio controls src={$audiopath}></audio>
            </figure>
HTML;
    }
}