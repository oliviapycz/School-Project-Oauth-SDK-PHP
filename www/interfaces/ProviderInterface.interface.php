<?php


interface ProviderInterface {

    /**
     * Return the provider name
     * @example google, facebook, ...
     */
    public function getProviderNameAction();

    /**
     * Return the authorization endpoint
     * @example http://auth-server/auth
     */
    public function getAuthorizationUrlAction();

    /**
     * Return the access token endpoint
     * @example http://auth-server/token
     */
    public function getAccessTokenUrlAction();
    
    /**
     * Return the user information
     * @example [
     *  "id" => "123456",
     *  "name" => "John Smith",
     *  "email" => "john.smith@domain.com"
     * ]
     */
    public function getUsersInfoAction(string $token);
}