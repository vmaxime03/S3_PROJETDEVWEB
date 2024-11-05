<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\CreateUserAction;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddTrackAction;
use iutnc\deefy\action\DisplayPlaylistListAction;
use iutnc\deefy\action\LogoutAction;
use iutnc\deefy\action\SignInAction;

class Dispatcher {
    private String $action;

    public function __construct() {
        $this->action = $_GET["action"]?? "none";
    }

    private function renderPage(String $html) : void {
        echo <<<END
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>DEEFY</title>
    </head> 
    <body>
        <h1>DEEFY</h1>
        <ul>
            <li><a href="?action=default">Acceuil</a></li>
            <br>
            <li><a href="?action=create-user">Create un compte</a></li>
            <li><a href="?action=signin">Se Connecter</a></li>
            <li><a href="?action=logout">Se deconecter</a></li>
            <br>
            <li><a href="?action=playlist-list">Afficher la listes des playlists</a></li>
            <li><a href="?action=playlist">Afficher playlist courante</a></li>
            <br>
            <li><a href="?action=add-playlist">Ajouter/remplacer playlist en session</a></li>
            <li><a href="?action=add-track">Ajouter track a la playlist courante</a></li>
            <br>
            
            <li><a href="?action=add-user">A RETIRER Ajouter utilisateur</a></li>
           
        </ul>
        
       <div>$html</div> 
    </body>
</html>
END;
    }

    public function run() : void {

        $this::renderPage((match ($this->action) {
            "default" => new DefaultAction(),
            "playlist" => new DisplayPlaylistAction(),
            "add-playlist" => new AddPlaylistAction(),
            "add-track" => new AddTrackAction(),
            "add-user" => new AddUserAction(),
            "signin" => new SigninAction(),
            "create-user" => new CreateUserAction(),
            "logout" => new LogoutAction(),
            "playlist-list" => new DisplayPlaylistListAction(),
            default => new DefaultAction()
        })->execute());


    }

}