<?php

namespace iutnc\deefy;

use PDO;

class DeefyRepository
{
    private PDO $pdo;
    private static ?DeefyRepository $instance;
    private static array $config = [ ];

    private function __construct(array $config) {
        $dsn = "".$config['driver'].":".$config['host'].";dbname=".$config['database'];
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

}