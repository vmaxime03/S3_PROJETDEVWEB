<?php

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\exceptions\InvalidPropertyNameException;

class AudioList implements \Iterator
{
    protected string $name;
    protected int $nbpiste;
    protected int $dureeTotale;
    protected array $list;
    public function __construct(string $name, array $list = [ ])
    {
        $this->name = $name;
        $this->list = $list;
        $this->nbpiste = count($this->list);
        $this->dureeTotale = 0;
        foreach ($list as $item) {
            if (property_exists($item, 'duree')) {
                $this->dureeTotale += $item->duree;
            }
        }
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException($name);
    }

    public function current()
    {
        return current($this->list);
    }

    public function next()
    {
        return next($this->list);
    }

    public function key()
    {
        return key($this->list);
    }

    public function valid()
    {
        return key($this->list) !== null;
    }

    public function rewind()
    {
        return reset($this->list);
    }
}