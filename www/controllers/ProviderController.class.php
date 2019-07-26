<?php


class ProviderController
{

    public function loginAction(): void
    {
        $class = $_GET['provider'].'Provider';
        $provider = new $class();
        $provider->login();
    }

    public function callBackAction(): void
    {
        $class = $_GET['provider'].'Provider';
        $provider = new $class();
        $provider->callBack();
        $provider->getUsersInfo($_SESSION['access_token']);

        header("Location: " . Routing::getSlug("Pages", "dashboard"));
    }

}