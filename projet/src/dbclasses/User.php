<?php

namespace iutnc\deefy\dbclasses;

use iutnc\deefy\exceptions\InvalidPropertyNameException;

class User
{
    public static int $ROLE_USER = 1;
    public static int $ROLE_ADMIN = 5;
    public static int $ROLE_SUPERADMIN = 100;

    public int $id;
    public string $email;
    public int $role;
    public $passwd;

    public function __construct($id, $email, $role, $passwd)
    {
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
        $this->passwd = $passwd;
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