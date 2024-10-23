<?php

namespace iutnc\deefy\renderer;

interface Renderer
{
    const COMPACT = 88;
    const LONG = 896;
    public function render(int $mode = self::COMPACT) : string;
}