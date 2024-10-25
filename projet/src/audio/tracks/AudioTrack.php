<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exceptions\InvalidPropertyNameException;
use iutnc\deefy\exceptions\InvalidPropertyValueException;

class AudioTrack
{
    const BLUES = 0;
    const DISCO = 4;
    const JAZZ = 8;
    public static function genreAsString(int $genre) : string
    {
        return match ($genre) {
            0 => "Blues                                              ",
            27 => "Trip hop                                           ",
            54 => "Eurodance                                          ",
            1 => "Classic rock                                       ",
            28 => "Musique vocale (vocal)                             ",
            55 => "Dream                                              ",
            2 => "Country                                            ",
            29 => "Jazz-funk                                          ",
            56 => "Rock sudiste (southern rock)                       ",
            3 => "Dance                                              ",
            30 => "Fusion                                             ",
            57 => "Comédie                                            ",
            4 => "Disco                                              ",
            31 => "Trance                                             ",
            58 => "Morceau \"culte\" (cult)                           ",
            5 => "Funk                                               ",
            32 => "Musique classique (classical)                      ",
            59 => "Gangsta                                            ",
            6 => "Grunge                                             ",
            33 => "Instrumental                                       ",
            60 => "Hit-parade (top 40)                                ",
            7 => "Hip-hop                                            ",
            34 => "Acid                                               ",
            61 => "Rap chrétien (christian rap)                       ",
            8 => "Jazz                                               ",
            35 => "House                                              ",
            62 => "Pop/Funk                                           ",
            9 => "Metal                                              ",
            36 => "Musique de jeu vidéo                               ",
            63 => "Jungle                                             ",
            10 => "New age                                            ",
            37 => "Extrait sonore (sound clip ou sample)              ",
            64 => "Musique amérindienne2                              ",
            11 => "Oldies                                             ",
            38 => "Gospel                                             ",
            65 => "Cabaret                                            ",
            12 => "Autre                                              ",
            39 => "Musique bruitiste (noise)                          ",
            66 => "New wave                                           ",
            13 => "Pop                                                ",
            40 => "Rock alternatif                                    ",
            67 => "Psychédélique                                      ",
            14 => "RnB                                                ",
            41 => "Bass                                               ",
            68 => "Rave                                               ",
            15 => "Rap                                                ",
            42 => "Soul                                               ",
            69 => "Comédie musicale (showtunes)                       ",
            16 => "Reggae                                             ",
            43 => "Punk                                               ",
            70 => "Bande-annonce                                      ",
            17 => "Rock                                               ",
            44 => "Space                                              ",
            71 => "Lo-fi                                              ",
            18 => "Techno                                             ",
            45 => "Musique de relaxation et de méditation (meditative)",
            72 => "Musique tribale                                    ",
            19 => "Musique industrielle (industrial)                  ",
            46 => "Pop instrumental                                   ",
            73 => "Acid punk                                          ",
            20 => "Rock alternatif (alternative)                      ",
            47 => "Rock instrumental                                  ",
            74 => "Acid jazz                                          ",
            21 => "Ska                                                ",
            48 => "Musique ethnique                                   ",
            75 => "Polka                                              ",
            22 => "Death metal                                        ",
            49 => "Gothique                                           ",
            76 => "Rétro                                              ",
            23 => "Pranks                                             ",
            50 => "Dark wave                                          ",
            77 => "Théâtre                                            ",
            24 => "Musique de film (soundtrack)                       ",
            51 => "Techno-industrial                                  ",
            78 => "Rock 'n' Roll                                      ",
            25 => "Euro techno                                        ",
            52 => "Musique électronique                               ",
            79 => "Hard rock                                          ",
            26 => "Ambient                                            ",
            53 => "Pop folk                                           ",
            default => "inconnu",
        };

    }



    protected string $titre;
    protected string $auteur;
    protected string $date;
    protected int $genre;
    protected int $duree;
    protected string $path;



    public function __construct(string $titre = 'unset', string $auteur = 'unset', string $date = 'unset', int $genre = -1, int $duree = -1, string $path = 'unset' )
    {
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->date = $date;
        $this->genre = $genre;
        $this->duree = $duree;
        $this->path = $path;
    }

    public function __get(string $name) : mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new InvalidPropertyNameException("$name is not a valid property");
        }
    }

    public function __set(string $name, $value) : void {
        if (property_exists($this, $name)) {
            switch ($name) {
                case 'duree':
                    if ($value < 0) {
                        throw new InvalidPropertyValueException("$value is not a valid value for $name");
                    }
                    $this->$name = $value;
                    break;
                case 'auteur':
                case 'date':
                case 'genre':
                case 'path':
                case 'titre':
                    $this->$name = $value;
                    break;
            }
        } else {
            throw new InvalidPropertyNameException("$name is not a valid property");
        }
    }
}

