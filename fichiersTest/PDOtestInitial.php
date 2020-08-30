<?php 

const HOST_NAME = "localhost";
const DB_NAME = "db_panierfruit";
const USER_NAME = "root";
const PWD = "";

//On rajoute un try/catch pour gérer les erreurs (3)
try{
    //On définit une variable de connexion (1) attention aux espaces avec le = et ;
    $connexion = 'mysql:host=' .HOST_NAME. ';dbname='.DB_NAME;

    //On génère une instance de PDO en utilisant la classe PDO et en utilisant notre variable
    // de connexion (on gère les exception avec le array -> facultatif) (2)
    $monPDO = new PDO($connexion, USER_NAME, PWD, array (pdo::ATTR_ERRMODE => pdo::ERRMODE_EXCEPTION));
} catch (PDOException $e){
    $message = "erreur de connexion à la DB ". $e->getMessage();
    die($message);
}

// On test si on est connecté et on réalise une première requête (4)
if($monPDO){
    $limitation = 130;
    //:valeur correspond à une variable qui permettra d'éviter des injections sql avec bindValue()
    $req ="select * from fruit where poids > :valeur";
    // prepare() permet d'éviter les injections sql
    $stmt = $monPDO->prepare($req);
    //$limitation represente la valeur que l'on souhaite utiliser (:valeur = $limitation) et 
    // PDO::PARAM_INT correspond au type de variable, ici un int
    $stmt -> bindValue(':valeur', $limitation, PDO::PARAM_INT);
    $stmt -> execute();
    //fetchAll permet de retourner un ensemble de résultat (toutes les lignes dans un tableau)
    $res1 = $stmt->fetchAll();
    echo "<pre>";
    print_r($res1);
    echo "</pre>";
}


?>
