<?php

require('./vendor/autoload.php');
require('SocialMediaLoginController.class.php');


class Facebook {

  public $id;
  public $secret;
  public $callback;


  public function __construct()
  {
    parent::__construct('facebook', 
                        '1105365973004688',
                        'aa7debccae2f885a25daacc489db6d3c',
                        'http://localhost:8098/facebook_callback');
  }
  
  public function getProviderNameAction() {

		return 'facebook';

  }
  
  public function loginFacebookAction() {

    //$helper = $facebook->getRedirectLoginHelper();
    //$permissions = ['email']; // Optional permissions
    $loginUrl = "'https://www.facebook.com/v3.3/dialog/oauth?client_id='.$this->id'&redirect_uri='.$this->callback'&state='.$this->state''";
    // $loginUrl = $helper->getLoginUrl('http://localhost:8098/facebook_callback', $permissions);
    header('Location:' .$loginUrl);
  }

  public function callbackFacebookAction() {
    $facebook = new Facebook\Facebook([
      'app_id' => '1105365973004688', // Replace {app-id} with your app id
      'app_secret' => 'aa7debccae2f885a25daacc489db6d3c',
      'default_graph_version' => 'v3.2',
      ]);
      $helper = $facebook->getRedirectLoginHelper();
  
      try {
          $accessToken = $helper->getAccessToken();
          $infoUrl = "https://graph.facebook.com/me?fields=id,name,email&access_token=".$accessToken;
          $hand = curl_init();

            curl_setopt($hand, CURLOPT_URL, $infoUrl);
            curl_setopt($hand, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($hand);
            if (curl_errno($hand)) {
                echo curl_error($hand);
                echo "</br>";
                echo $infoUrl;
            }



            $output = json_decode($output);
            $_SESSION['facebook']['name'] = urldecode($output->name);
            header("Location: " . Routing::getSlug("Pages", "dashboard"));
      } catch (Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
      }
  }

  public function getUsersInfoAction($infoUrl) {
    
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
            echo "votre nom est : ".urldecode($output->name)."<br> et votre email : ".urldecode($output->email);
            curl_close($hand);
  }
	

}