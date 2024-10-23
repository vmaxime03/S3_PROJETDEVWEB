<?php

namespace iutnc\deefy\action;

require __DIR__ . '/../../vendor/autoload.php';

abstract class Action {

    protected ?string $http_method = null;
    protected ?string $hostname = null;
    protected ?string $script_name = null;

    public function __construct(){

        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    public function execute() : string {
        return match ($this->http_method) {
            'GET' => $this->get(),
            'POST' => $this->post()
        };
    }

    abstract public function get() : string;
    abstract public function post() : string;
}