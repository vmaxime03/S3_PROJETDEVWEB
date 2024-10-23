<?php

namespace iutnc\deefy\loader;

class Loader
{
    const DIRECTORY_SEPARATOR = "/";
    const NAMESPACE_SEPARATOR = "\\";

    private string $namespace;
    private string $directory;
    public function __construct(string $namespace, string $directory)
    {
        $this->namespace = $namespace;
        $this->directory = $directory;

    }

    public function loadClass($className) : void {
        if (str_starts_with($className, $this->namespace)) {
            $path = str_replace($this->namespace, $this->directory, $className);
            $path = str_replace(self::NAMESPACE_SEPARATOR, self::DIRECTORY_SEPARATOR, $path) . ".php";
            if (is_file($path)){
                require_once $path;
            }
        }

    }

    public function register(): void
    {
        spl_autoload_register([$this, "loadClass"]);
    }
}