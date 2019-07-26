<?php


abstract class Provider
{
    public $name;
    public $id;
    public $secret;
    public $callback;

    public function __construct($name, $id, $secret, $callback) {
        $this->name = $name;
        $this->id = $id;
        $this->secret = $secret;
        $this->callback = $callback;
    }

    abstract public function getProviderName(): string;

    abstract public function getAuthorizationUrl(): string;

    abstract public function getAccessTokenUrl(): string;

    abstract public function getUsersInfo(string $token): void;

    abstract public function callBack(): void;

    abstract public function login(): void;
}