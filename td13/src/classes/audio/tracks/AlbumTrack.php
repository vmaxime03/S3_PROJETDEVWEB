<?php

namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack
{
    private string $album;
    private int $numero;

    public function __construct(
        string $titre, string $path, string $album, int $numero)
    {
        parent::__construct($titre,'unset', 'unset', -1,-1, $path);
        $this->album = $album;
        $this->numero = $numero;

    }

    public function __get(string $name) : mixed
    {
        switch ($name) {
            case 'artiste':
                return $this->auteur;
            case 'annee':
                return $this->date;
            case 'album':
            case 'numero':
                return $this->$name;
            default:
                return parent::__get($name);
        }
    }

    public function __set(string $name, $value): void
    {
        switch ($name) {
            case 'path':
            case 'album':
            case 'numero':
            case 'titre': break;
            default:
                parent::__set($name, $value);
        }
    }

    public function __toString(): string
    {
        return json_encode($this);
    }
}