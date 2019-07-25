<?php

declare(strict_types=1);

class Validator {

  public $errors = [];

  public function __construct( $config, $data ) {

    //Vérification du nombre de champs
    if (count($data)!=count($config["data"])) {
      die("Tentative Faille XSS");
    }

    foreach ($config["data"] as $name => $input) {
      
      //required
      if($input["required"] && empty($data[$name])) {
        die("Tentative Faille XSS");
      }else{

        //Minlength
        if(isset($input["minlenght"]) && !self::checkMinLength($data[$name], $input["minlenght"]) ){
          $this->errors[] = $input["error"];
          continue;
        }

        //Maxlength
        if(isset($input["maxlenght"]) && !self::checkMaxLength($data[$name], $input["maxlenght"]) ){
          $this->errors[] = $input["error"];
          continue;
        }

        //Email
        if($input["type"]=="email" && !self::checkEmail($data[$name])) {
          $this->errors[] = $input["error"];
          continue;
        }

        //Pwd
        if($input["type"]=="password" && !self::checkPwd($data[$name])) {
          $this->errors[] = $input["error"];
          continue;
        }

        //Confirm
        if(isset($input["confirm"]) && $data[$name]!=$data[$input["confirm"]]) {
          $this->errors[] = $input["error"];
          continue;
        }
      }

    }
  }

  public static function checkMinLength($string, $length) {
    return strlen(trim($string))>=$length;
  }

  public static function checkMaxLength($string, $length) {
    return strlen(trim($string))<=$length;
  }

  public static function checkEmail($string) {
    return filter_var($string, FILTER_VALIDATE_EMAIL);
  }

  public static function checkPwd($string) {
    return ( preg_match("/[A-Z]/", $string) &&
             preg_match("/[a-z]/", $string) &&
             preg_match("/[0-9]/", $string) );
  }

}