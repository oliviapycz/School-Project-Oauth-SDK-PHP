<?php


class GithubProvider extends Provider
{
    public function __construct()
    {
        parent::__construct('github',
            GITHUB_APP_ID,
            GITHUB_APP_SECRET,
            GITHUB_REDIRECT_URL);
    }

    public function getProviderName(): string
    {
        return 'github';
    }

    public function getAuthorizationUrl(): string
    {
        return 'https://github.com/login/oauth/authorize';
    }

    public function getAccessTokenUrl(): string
    {
        return 'https://github.com/login/oauth/access_token';
    }

    public function getUsersInfo(string $token): void
    {
        $infoUrl = "https://api.github.com/user";

        $hand = curl_init();
        curl_setopt($hand, CURLOPT_URL, $infoUrl);
        curl_setopt($hand, CURLOPT_HTTPHEADER, array("Authorization: token $token"));
        curl_setopt($hand, CURLOPT_USERAGENT, 'OauthSdkProject');
        // curl_setopt($hand, CURLOPT_USERAGENT, 'oliviapycz');
        curl_setopt($hand, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($hand);
        if (curl_errno($hand)) {
            echo curl_error($hand);
            echo "</br>";
            echo $$infoUrl;
        }
        $output = json_decode($output);

        $_SESSION['github']['name'] = urldecode($output->login);
        $_SESSION['github']['email'] = urldecode($output->email);
        $_SESSION['github']['img_url'] = urldecode($output->avatar_url);
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
        $parameters = explode('=',$output);
        $access_token = substr($parameters[1], 0, -6);

        $_SESSION['github_access_token'] = $access_token;
    }

    public function login(): void
    {
        $state = 'stateisok';
        $githubUrl = $this->getAuthorizationUrl();
        $githubUrl .= "?response_type=code&scope=user&client_id=$this->id&redirect_uri=$this->callback&state=$state";
        header('Location:'.$githubUrl);
    }
}