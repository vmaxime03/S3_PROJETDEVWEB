<?php

namespace iutnc\deefy\db;
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


    public function findUserByEmail(string $email) : mixed
    {
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    public function addUser(string $email, string $passwd) : void
    {
        $role = User::$ROLE_USER;

        $query = "INSERT INTO user (id, email, passwd, role) VALUES (NULL, '$email',  '$passwd', $role)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }



}