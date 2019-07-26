<?php


class HerokuProvider extends Provider
{
    public function __construct()
    {
        parent::__construct('heroku',
            HEROKU_APP_ID,
            HEROKU_APP_SECRET,
            HEROKU_REDIRECT_URL);
    }

    public function getProviderName(): string
    {
        return 'heroku';
    }

    public function getAuthorizationUrl(): string
    {
        return 'https://id.heroku.com/oauth/authorize';
    }

    public function getAccessTokenUrl(): string
    {
        return 'https://id.heroku.com/oauth/token';
    }

    public function getUsersInfo(string $token): void
    {
        $infoUrl = "https://api.heroku.com/account?access_token=".$token;

        $hand = curl_init();
        curl_setopt($hand, CURLOPT_URL, $infoUrl);
        curl_setopt($hand, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token", "Accept: application/vnd.heroku+json; version=3"));
        curl_setopt($hand, CURLOPT_USERAGENT, 'OauthSdkProject');
        curl_setopt($hand, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($hand);
        if (curl_errno($hand)) {
            echo curl_error($hand);
            echo "</br>";
            echo $$infoUrl;
        }
        $output = json_decode($output);

        $_SESSION['heroku']['name'] = urldecode($output->name);
        $_SESSION['heroku']['email'] = urldecode($output->email);
    }

    public function callBack(): void
    {
        $code = $_GET['code'];
        $uri = $this->getAccessTokenUrl();

        $hand = curl_init();
        curl_setopt($hand, CURLOPT_URL, $uri);
        curl_setopt($hand, CURLOPT_POST, 1);
        curl_setopt($hand, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=$code&client_secret=$this->secret");
        curl_setopt($hand, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($hand);
        if (curl_errno($hand)) {
            echo curl_error($hand);
            echo "</br>";
            echo $$uri;
        }
        $output = json_decode($output);

        $_SESSION['heroku_access_token'] = $output;
    }

    public function login(): void
    {
        // TODO: Implement login() method.
    }
}