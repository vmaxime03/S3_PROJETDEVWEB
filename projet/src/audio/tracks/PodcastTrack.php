<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exceptions\InvalidPropertyNameException;

class PodcastTrack extends AudioTrack
{
    protected string $auteur;
    protected string $date;

    public function __construct(
        string $titre, string $genre, int $duree, string $filename, string $auteur, string $date)
    {
        parent::__construct($titre, $genre, $duree, $filename);
        $this->auteur = $auteur;
        $this->date = $date;
    }

    public function __get(string $name) : mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new InvalidPropertyNameException("$name is not a valid property");
        }
    }

    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new InvalidPropertyNameException("$name is not a valid property");
        }
    }

}