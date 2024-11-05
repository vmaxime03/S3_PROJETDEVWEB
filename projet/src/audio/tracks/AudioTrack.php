<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exceptions\InvalidPropertyNameException;
use iutnc\deefy\exceptions\InvalidPropertyValueException;

class AudioTrack
{



    protected string $titre;
    protected string $genre;
    protected int $duree;
    protected string $filename;



    public function __construct(string $titre, string $genre, int $duree, string $filename)
    {
        $this->titre = $titre;
        $this->genre = $genre;
        $this->duree = $duree;
        $this->filename = $filename;
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

