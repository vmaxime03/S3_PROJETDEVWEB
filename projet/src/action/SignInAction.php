<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthProvider;
use iutnc\deefy\auth\AuthException;

class SignInAction extends Action
{

    public function get(): string
    {
        return <<<FORM
<form action="?action=signin" method="POST">
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

        AuthProvider::getSignedInUser();

        try {
            AuthProvider::signin();
        } catch (AuthException $e) {
            return "la connection a echouée";
        }

        $_SESSION["userEmail"] = $_POST['userEmail'];
        return "connection reussie";
    }
}