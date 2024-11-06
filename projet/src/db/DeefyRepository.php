<?php

namespace iutnc\deefy\db;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\dbclasses\User;
use PDO;

class DeefyRepository
{
    private PDO $pdo;
    private static ?DeefyRepository $instance;
    private static array $config = [ ];

    private function __construct(array $config) {
        $dsn = "".$config['driver'].":host=".$config['host'].";dbname=".$config['database'];
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
    }

    public static function getInstance(): DeefyRepository {
        if (!isset(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file): void {
        self::$config = parse_ini_file($file);
    }

    public function findAllPlaylists() : array
    {
        $query = "SELECT * FROM playlist";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function findUserByEmail(string $email) : User|null
    {
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user) {
            return new User($user->id, $user->email, $user->role, $user->passwd);
        } else {
            return null;
        }
    }

    public function addUser(string $email, string $passwd) : void
    {
        $role = User::$ROLE_USER;

        $query = "INSERT INTO user (id, email, passwd, role) VALUES (NULL, '$email',  '$passwd', $role)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function getPlaylist(int $plid) : mixed
    {
        $query = "SELECT * FROM playlist WHERE id = $plid";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getUserPlaylists(mixed $userid) : array {
        $query = "SELECT * FROM playlist p INNER JOIN user2playlist u ON p.id = u.id_pl WHERE u.id_user = $userid";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function getPlaylistTracks(mixed $plid) : array {

        $query = "SELECT * FROM track t INNER JOIN playlist2track p ON t.id = p.id_track WHERE p.id_pl = $plid";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addPlaylistToUser(string $playlist, string $email) : int {
        $query = "INSERT INTO playlist (id, nom) VALUES (NULL, '$playlist')";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $playlistid = $this->pdo->lastInsertId();

        $userid = $this->findUserByEmail($email)->id;

        $query2 = "INSERT INTO user2playlist (id_pl, id_user) VALUES ('$playlistid', '$userid')";
        $stmt3 = $this->pdo->prepare($query2);
        $stmt3->execute();

        return $playlistid;
    }

    public function addTrackToPlaylist(AudioTrack $track, int $plid, int $no_piste_dans_liste) : void
    {
        if ($track instanceof AlbumTrack) {
            $query =  "INSERT INTO track (id, titre, genre, duree, filename, type, artiste_album, 
                   titre_album, annee_album, numero_album) 
                    VALUES (NULL, '$track->titre', '$track->genre', '$track->duree',
                            '$track->filename', 'A', '$track->artiste', '$track->album',  
                            $track->annee, $track->numero)";
        } elseif ($track instanceof PodcastTrack) {
            $query =  "INSERT INTO track (id, titre, genre, duree, filename, type, auteur_podcast, date_posdcast) 
                    VALUES (NULL, '$track->titre', '$track->genre', '$track->duree',
                            '$track->filename', 'P', '$track->auteur', '$track->date')";
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $trackid = $this->pdo->lastInsertId();


        $query2 = "INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) 
                    VALUES ('$plid', '$trackid', $no_piste_dans_liste)";
        $stmt3 = $this->pdo->prepare($query2);
        $stmt3->execute();

    }


    public function getPlaylistOwnerId(string $plid) : int {
        $query = "SELECT id_user FROM user2playlist WHERE id_pl = $plid";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->id_user;
    }

    public function getUserById(string $userid) : User {
        $query = "SELECT * FROM user WHERE id = $userid";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $user =$stmt->fetch(PDO::FETCH_OBJ);
        return new User($user->id, $user->email, $user->role, $user->passwd);
    }




}