<?php

class View {

	private $view;
	private $template;
	private $data = [];

	public function __construct($view, $template="front") {
		$this->setView($view);
		$this->setTemplate($template);
	}


	public function setView($view) {
		$pathView = "views/".$view.".view.php";
		if(file_exists($pathView)){
			$this->view = $pathView;	
		}else{
			die("La vue n'existe pas :".$pathView);
		}
	}
	public function setTemplate($template) {
		$pathTemplate = "views/templates/".$template.".tpl.php";
		if(file_exists($pathTemplate)){
			$this->template = $pathTemplate;	
		}else{
			die("Le template n'existe pas :".$pathTemplate);
		}
	}

	public function addModal($modal, $config){
		$pathModal = "views/modals/".$modal.".mod.php";
		if(file_exists($pathModal)){
			include $pathModal;	
		}else{
			die("Le modal n'existe pas :".$pathModal);
		}
	}
	
	public function assign($key, $value) {
		$this->data[$key]=$value;
	}

	public function __destruct() {
		extract($this->data);
		include $this->template;
	}

}



