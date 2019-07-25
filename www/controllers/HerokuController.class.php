<?php

require('SocialMediaLoginController.class.php');

class HerokuController extends SocialMediaLoginController {

  public function __construct()
  {
      parent::__construct('heroku', 
                          HEROKU_APP_ID, 
                          HEROKU_APP_SECRET, 
                          HEROKU_REDIRECT_URL);
  }

  public function getProviderNameAction()
  {
		return 'heroku';
  }
  
  public function getBaseAuthorizationUrl()
  {
      return 'https://id.heroku.com/oauth/authorize';
  }

  public function getBaseAccessTokenUrl()
  {
      return 'https://id.heroku.com/oauth/token';
  }

  public function loginHerokuAction()
  {
    $state = 'stateisok';
    $herokuUrl = $this->getBaseAuthorizationUrl();
    $herokuUrl .= "?response_type=code&client_id=$this->id&scope=identity&state=$state";
    header('Location:'.$herokuUrl);
  }

  public function callbackHerokuAction()
  {
    $code = $_GET['code'];
    $uri = $this->getBaseAccessTokenUrl();

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

    $this->getUsersInfoAction(urldecode($output->access_token));
  }

  public function getUsersInfoAction(string $token)
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

    header("Location: " . Routing::getSlug("Pages", "dashboard"));

		return array();
	}

}