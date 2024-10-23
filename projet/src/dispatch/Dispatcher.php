<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddTrackAction;

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
            <li><a href="?action=add-playlist">Ajouter/remplacer playlist en session</a></li>
            <li><a href="?action=add-track">Ajouter track a la playlist</a></li>
            <li><a href="?action=playlist">Afficher playlist</a></li>
            <li><a href="?action=default">Action par defaut</a></li>
            <li><a href="?action=add-user">Ajouter utilisateur</a></li>
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
            default => new DefaultAction()
        })->execute());


    }

}