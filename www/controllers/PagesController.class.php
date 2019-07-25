<?php
class PagesController{


	public function defaultAction() {

		$view = new View("homepage", "front");

	}

	public function dashboardAction() {
		$error = '';
		if (isset($_SESSION['user']) || isset($_SESSION['facebook']) || isset($_SESSION['heroku']) || isset($_SESSION['github'])) {
			$view = new View("dashboard", "front");
		}	else {
			$error = 'Vous devez être connecté.e pour accéder à cette page';
			$view = new View("homepage", "front");
			$view->assign('error', $error);
		}
		
	}

}