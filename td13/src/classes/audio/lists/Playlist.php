<?php

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack;

class Playlist extends AudioList
{
    public function __construct(string $name, array $list = [])
    {
        parent::__construct($name, $list);
    }
    public function addTrack(AudioTrack $track) : void {
        $this->list[] = $track;
        $this->nbpiste++;
        $this->dureeTotale += $track->duree ?? 0;
    }
    public function removeTrack(int $trackIndex) : void {
        $this->dureeTotale -= $this->list[$trackIndex]->duree;
        $this->nbpiste--;
        unset($this->list[$trackIndex]);
    }
    public function addListTrack(array $arraylist) : void {
        foreach ($arraylist as $track) {
            if ($track instanceof AudioTrack) {
                if (!in_array($track, $this->list)) {
                    $this->addTrack($track);
                }
            }
        }
    }
}