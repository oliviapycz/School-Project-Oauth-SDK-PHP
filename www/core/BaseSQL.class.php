<?php

declare(strict_types=1);

class BaseSQL {

  private $pdo; 
  private $table;

  public function __construct(){
    // A CONNAITRE PAR COEUR
    // PDO -> PHP Data Object
    // PHP -> PHP Hypertext Preprocessor

    // Avec un singleton c'est mieux....
    try{
      $this->pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPWD);
    }catch(Exception $e){
      die(" Erreur SQL : ".$e->getMessage());
    }
    // récuperer le nom de la class qui est aussi le nom de la table
    //on procède dans le constructeur car on aura besoin de cette variable partout
    $this->table = get_called_class();
  }

  public function getColumns() {
    // on récupère toutes les variables parent et enfants
    $objectVars = get_object_vars($this);
    // on récupère seulement les variables du parent
    $classVars = get_class_vars( get_class() );
    // on compare les 2 tableaux récupérés
    // pour ne garder que les éléments communs (ni pdo, ni table du parent)
    $columns = array_diff_key($objectVars, $classVars);
    return $columns;
    
  }

  // Dynamique en fonction de l'enfant qui en hérite
  public function save(){
    $columns = $this->getColumns();
    if( is_null($columns["id"]) ){
      # INSERT
      $sql = "INSERT INTO ".$this->table." (".implode(",", array_keys($columns)).")
      VALUES (:".implode(",:", array_keys($columns)).")";
      // echo $sql;
      $query = $this->pdo->prepare($sql);
      $query->execute( $columns );
    }else{
      # UPDATE
      // pour ne pas écraser tous les champs par l'update
      // quand on setId la fonction getOneBy se lance et remplit tous les champs
      foreach ($columns as $key => $value) {
        $sqlSet[] = "".$key." =:".$key."";
      }
      $sql = "UPDATE ".$this->table."
      SET ".implode(",", $sqlSet)." WHERE id=:id";
      echo $sql;
      $query = $this->pdo->prepare($sql);
      $query->execute( $columns );
    }
  }
  // de type $where=["id"=>3, "email"=>"olivia@gmail.com"]
  public function getOneBy(array $where, $object = false){
    $columns = $this->getColumns();     

    foreach ($where as $key => $value) {
      $sqlWhere[] = "".$key." =:".$key."";
    }
    $sql = "SELECT * FROM ".$this->table."
      WHERE ".implode(" AND ", $sqlWhere)."";
      // echo $sql;
      $query = $this->pdo->prepare($sql);
      if ($object) {
        // modifie l'instance en cours
        // remplit $this avec les valeurs de la bdd
        // avant de modifier les champs dans le update
        // prend object existant et écrase les valeurs avec les valeurs de la base
        $query->setFetchMode(PDO::FETCH_INTO, $this);
      } else {
        $query->setFetchMode(PDO::FETCH_ASSOC);
      }
      $query->execute( $where );
      // fetch() retourne le 1er résultat != fetchAll()
      return $query->fetch();
  }

}