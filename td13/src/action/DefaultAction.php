<?php

namespace iutnc\deefy\action;

class DefaultAction extends Action
{

    public function get(): string
    {
        return "BIENVENUE";
    }

    public function post(): string
    {
        return "post";
    }
}