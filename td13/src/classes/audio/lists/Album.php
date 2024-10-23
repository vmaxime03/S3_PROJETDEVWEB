<?php

namespace iutnc\deefy\audio\lists;

class Album extends AudioList
{
    protected string $artiste;
    protected string $date;

    public function __construct(string $name, array $list)
    {
        parent::__construct($name, $list);
    }

    public function setArtiste(string $artiste) {
        $this->artiste = $artiste;
    }
    public function setDate(string $date) {
        $this->date = $date;
    }
}