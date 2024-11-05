<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exceptions\InvalidPropertyNameException;

class AlbumTrack extends AudioTrack
{
    private string $artiste;
    private string $album;
    private int $annee;
    private int $numero;

    public function __construct(
        string $titre, string $genre, int $duree, string $filename, string $artiste, string $album, int $annee, int $numero)
    {
        parent::__construct($titre, $genre, $duree, $filename);
        $this->artiste = $artiste;
        $this->album = $album;
        $this->annee = $annee;
        $this->numero = $numero;
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

    public function __toString(): string
    {
        return json_encode($this);
    }
}