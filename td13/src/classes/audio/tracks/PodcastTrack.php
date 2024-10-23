<?php

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack
{
    public function __construct(string $titre, string $auteur, string $date, int $genre, int $duree, string $path)
    {
        parent::__construct($titre, $auteur, $date, $genre, $duree, $path);
    }

}