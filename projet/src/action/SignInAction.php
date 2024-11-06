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

        try {
            $user = AuthProvider::getSignedInUser();
            if ($user->email === $_POST["userEmail"] &&
                password_verify($_POST['userPasswd'], $user->passwd)) {
                return "connection reussie : session";
            } else {
                throw new AuthException();
            }
        } catch (AuthException $e) {
            try {
                AuthProvider::signin($_POST["userEmail"], $_POST["userPasswd"]);
                unset($_SESSION['playlist']);
                return "connection reussie : nouvelle connection";
            } catch (AuthException $e) {
                return "erreur lors de la connexion";
            }
        }

    }
}