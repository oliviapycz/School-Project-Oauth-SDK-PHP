<?php
require('./interfaces/ProviderInterface.interface.php');

abstract class SocialMediaLoginController implements ProviderInterface {

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

	public function getProviderNameAction() {

		return string;

	}

	public function getAuthorizationUrlAction(){

		return string;
	}

	public function getAccessTokenUrlAction() {
		return string;
	}

	public function getUsersInfoAction(string $token) {
		return array();
	}
}