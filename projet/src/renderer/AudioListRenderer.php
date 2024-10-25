<?php

namespace iutnc\deefy\renderer;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\renderer\RendererFactory;

class AudioListRenderer implements Renderer
{
    private AudioList $audioList;

    public function __construct(AudioList $audioList)
    {
        $this->audioList = $audioList;
    }


    public function render(int $mode = self::COMPACT) : string
    {
        $r = "<h1>" . $this->audioList->name . "</h1>\n <ul>\n";
        foreach ($this->audioList->list as $audio) {
            $r .= "\t<li>" .  RendererFactory::getRenderer($audio)->render($mode) . "</li>\n";
        }
        $r .= "</ul>\n";
        return $r;
    }
}