<?php

class Users extends BaseSQL {

  public $id = null;
  public $firstname;
  public $lastname;
  public $email;
  public $pwd;

  public function __construct(){
    parent::__construct();
  }

  public function setId($id){
    $this->id=$id;
    $this->getOneBy(["id"=>$id], true);
  }

  public function setFirstname($firstname){
    $this->firstname=ucwords(strtolower(trim($firstname)));

  }

  public function setLastname($lastname){
    $this->lastname=strtoupper(trim($lastname));
  }

  public function setEmail($email){
    return $this->email=strtolower(trim($email));
  }

  public function setPwd($pwd){
    $this->pwd=password_hash($pwd, PASSWORD_DEFAULT);
  }

  public function getFormLogin(){
    return [
      "config"=>[
        "method"=>"POST",
        "action"=>Routing::getSlug("Users", "checkCredentials"),
        "class"=>"",
        "id"=>"",
        "submit"=>"Login"
      ],
      "data"=>[
        "email"=>[
          "type"=>"email",
          "placeholder"=>"Votre email",
          "class"=>"form-control",
          "id"=>"email",
          "required"=> true,
          "minlength"=>7,
          "maxlength"=>250,
          "error"=>"Pas d\'utilisateur.trice avec cet email"
        ],
        "pwd"=>[
          "type"=>"password",
          "placeholder"=>"Votre mot de passe",
          "class"=>"form-control",
          "id"=>"pwd",
          "required"=> true,
          "minlength"=>6,
          "error"=>"Mauvais mot de passe"
        ]
      ]
    ];
  }

  public function getFormRegister(){
    return [
      "config"=>[
        "method"=>"POST",
        "action"=>Routing::getSlug("Users", "save"),
        "class"=>"",
        "id"=>"",
        "reset"=>"Annuler",
        "submit"=>"S'enregistrer"
      ],
      "data"=>[
        "firstname"=>[
          "type"=>"text",
          "placeholder"=>"Votre prénom",
          "class"=>"form-control",
          "id"=>"firstname",
          "required"=>true,
          "minlength"=>2,
          "maxlength"=>50,
          "error"=>"Votre prénom doit faire entre 2 et 50 caractères"
        ],
        "lastname"=>[
          "type"=>"text",
          "placeholder"=>"Votre nom",
          "class"=>"form-control",
          "id"=>"lastname",
          "required"=> true,
          "minlength"=>2,
          "maxlength"=>100,
          "error"=>"Votre nom doit faire entre 2 et 100 caractères"
        ],
        "email"=>[
          "type"=>"email",
          "placeholder"=>"Votre email",
          "class"=>"form-control",
          "id"=>"email",
          "required"=> true,
          "minlength"=>7,
          "maxlength"=>250,
          "error"=>"Votre email n'est pas correct ou fait plus de 250 caractères"
        ],
        "pwd"=>[
          "type"=>"password",
          "placeholder"=>"Votre mot de passe",
          "class"=>"form-control",
          "id"=>"pwd",
          "required"=> true,
          "minlength"=>6,
          "error"=>"Votre mot de passe doit faire plus de 6 caractères avec des minuscules, majuscules et des chiffres"
        ],
        "pwdConfirm"=>[
          "type"=>"password",
          "placeholder"=>"Retapez votre mot de passe",
          "class"=>"form-control",
          "id"=>"pwdConfirm",
          "required"=> true,
          "confirm"=>"pwd",
          "error"=>"Le mot de passe ne correspond pas"
        ]
      ]
    ];
  }
  
}