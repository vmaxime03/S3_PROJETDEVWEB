<?php

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthException;
use iutnc\deefy\auth\AuthProvider;

class LogoutAction extends Action
{

    public function get(): string
    {
        try {
            $user = AuthProvider::getSignedInUser();
            return <<<html
<p> user : $user->email, role : $user->role</p>
<form action="?action=logout" method="POST">
    <input type="submit" value="Se deconecter">
</form>

html;
        } catch (AuthException $e) {
            return <<<html
<p>No user Conected</p>
html;
        }


    }

    public function post(): string
    {
        unset($_SESSION['user']);
        return <<<html
<p> user disconected</p>
html;

    }
}