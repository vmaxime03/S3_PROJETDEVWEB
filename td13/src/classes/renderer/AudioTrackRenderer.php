<?php

namespace iutnc\deefy\renderer;

abstract class AudioTrackRenderer implements Renderer
{
    abstract function renderCompact() : string;
    abstract function renderLong() : string;

    function render(int $mode = self::COMPACT): string
    {
        switch ($mode) {
            case self::LONG:
                return $this->renderLong();
            default:
                return $this->renderCompact();
        }
    }
}