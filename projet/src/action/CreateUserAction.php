<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthException;
use iutnc\deefy\auth\AuthProvider;

class CreateUserAction extends Action
{

    public function get(): string
    {
        return <<<FORM
<form action="?action=create-user" method="POST">
            <input type="email" name="userEmail" placeholder="email">
            <input type="password" name="userPasswd" placeholder="mot de passe">
            <input type="submit" value="Confirmer">
</form>
FORM;
    }

    public function post(): string
    {

        if (!(isset($_POST['userEmail']) && isset($_POST['userPasswd'])) ||
            $_POST['userEmail'] == "" || $_POST['userPasswd'] == "") {
            return "entrée manquante";
        }

        try {
            AuthProvider::register($_POST["userEmail"], $_POST["userPasswd"]);
            return "User cree avec succes";
        } catch (AuthException $e) {
            return "Erreur : " . $e->getMessage();
        }

    }
}