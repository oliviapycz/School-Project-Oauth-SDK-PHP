<?php


class UsersController {


	public function defaultAction(){
		echo "User default";
	}


	public function addAction(){
	
		$user = new Users();
		$view = new View("addUser", "front");
		$view->assign("configFormRegister", $user->getFormRegister());
		
	}

	public function loginAction(){
	
		$user = new Users();
		$view = new View("loginUser", "front");
		$view->assign("configFormLogin", $user->getFormLogin());
	}

	public function checkCredentialsAction(){
		$user = new Users();
		$configForm = $user->getFormLogin();
		$method = strtoupper($configForm["config"]["method"]);
		$data = $GLOBALS["_".$method];
		if ($_SERVER["REQUEST_METHOD"]==$method && !empty($data)) {
			$email = $user->setEmail($data["email"]);
			$retrievedUser = $user->getOneBy(["email" => $email]);
			if (!empty($retrievedUser)) {
					if ($retrievedUser["email"] == $data["email"] && password_verify($data["pwd"], $retrievedUser["pwd"])) {
							if (!isset($_SESSION['user'])) {
									$_SESSION['user']['firstname'] = $data["firstname"];
									$_SESSION['user']['lastname'] = $data["lastname"];
									header("Location: " . Routing::getSlug("Pages", "dashboard"));
							}
					} else {
						$configForm["errors"][0] = 'Mauvais mot de passe';
					}
			} else {
				$configForm["errors"][0] = 'Pas d\'utilisateur.trice avec cet email';
			}
		}
		$view = new View("loginUser", "front");
		$view->assign("configFormLogin", $configForm);
    }

	public function logoutAction(){
	
		unset($_SESSION['user']);
		unset($_SESSION['facebook']);
		unset($_SESSION['heroku']);
		unset($_SESSION['github']);

		$view = new View("logoutUser", "front");
		
	}

	public function saveAction(){

		$user = new Users();
		$configForm = $user->getFormRegister();
		$method = strtoupper($configForm["config"]["method"]);
		
		$data = $GLOBALS["_".$method];
		if($_SERVER["REQUEST_METHOD"]==$method && !empty($data)) {

			$validator = new Validator($configForm, $data);
			$configForm["errors"] = $validator->errors;

			if (empty($configForm["errors"])) {
				$user->setFirstname($data["firstname"]);
				$user->setLastname($data["lastname"]);
				$user->setEmail($data["email"]);
				$user->setPwd($data["pwd"]);
				$user->save();
				if (!isset($_SESSION['user'])) {
					$_SESSION['user']['firstname'] = $data["firstname"];
					$_SESSION['user']['lastname'] = $data["lastname"];
					$_SESSION['user']['name'] = $data["firstname"];
					$_SESSION['user']['name'] .= ' ';
					$_SESSION['user']['name'] .= $data["lastname"];
			}
				header("Location: " . Routing::getSlug("Pages", "dashboard"));
			}
		}
		$view = new View("addUser", "front");
		$view->assign("configFormRegister", $configForm);
	}

}
