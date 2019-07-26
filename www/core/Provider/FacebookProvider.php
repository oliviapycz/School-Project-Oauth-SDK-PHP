<?php


class FacebookProvider extends Provider
{
    public function __construct()
    {
        parent::__construct('facebook',
            FB_APP_ID,
            FB_APP_SECRET,
            FB_REDIRECT_URL);
    }

    public function getProviderName(): string
    {
        return 'facebook';
    }

    public function getAuthorizationUrl(): string
    {
        return 'https://www.facebook.com/v3.3/dialog/oauth';
    }

    public function getAccessTokenUrl(): string
    {
        return 'https://graph.facebook.com/v3.3/oauth/access_token';
    }

    public function getUsersInfo(string $token): void
    {
        $infoUrl = "https://graph.facebook.com/me?fields=id,name,email,picture&access_token=".$token;

        $hand = curl_init();
        curl_setopt($hand, CURLOPT_URL, $infoUrl);
        curl_setopt($hand, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($hand);
        if (curl_errno($hand)) {
            echo curl_error($hand);
            echo "</br>";
            echo $$infoUrl;
        }
        $output = json_decode($output);

        $_SESSION['facebook']['name'] = urldecode($output->name);
        $_SESSION['facebook']['email'] = urldecode($output->email);
        $_SESSION['facebook']['img_url'] = urldecode($output->picture->data->url);
    }

    public function callBack(): void
    {
        $code = $_GET['code'];
        $uri = $this->getAccessTokenUrl();
        $uri .= "?client_id=$this->id&redirect_uri=$this->callback&client_secret=$this->secret&code=$code";

        $hand = curl_init();
        curl_setopt($hand, CURLOPT_URL, $uri);
        curl_setopt($hand, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($hand);
        if (curl_errno($hand)) {
            echo curl_error($hand);
            echo "</br>";
            echo $$uri;
        }
        $output = json_decode($output);

        $_SESSION['access_token'] = urldecode($output->access_token);
    }

    public function login(): void
    {
        $state = 'stateisok';
        $facebookUrl = $this->getAuthorizationUrl();
        $facebookUrl .= "?response_type=code&client_id=$this->id&redirect_uri=$this->callback&state=$state";
        header('Location:'.$facebookUrl);
    }
}