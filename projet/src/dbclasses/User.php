<?php

namespace iutnc\deefy\dbclasses;

class User
{
    public static int $ROLE_USER = 1;
    public static int $ROLE_ADMIN = 2;
    public static int $ROLE_SUPERADMIN = 3;

    public $id;
    public $email;
    public $role;

    public function __construct($id, $email, $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
    }



}