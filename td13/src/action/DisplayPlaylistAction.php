<?php

namespace iutnc\deefy\action;

use iutnc\deefy\renderer\RendererFactory;

class DisplayPlaylistAction extends Action
{

    public function get(): string
    {


        if (isset($_SESSION['playlist']))
            return RendererFactory::getRenderer($_SESSION['playlist'])->render();
        else
            return "playliste inexistante";
    }

    public function post(): string
    {
        return "POST display playlist";
    }
}