<?php

require_once "classes/panier.class.php";
require_once "classes/monPDO.class.php";

class PanierManager{

    public static function setPaniersFromDB(){
        $pdo = monPDO::getPDO();
        //On veut récupérer toutes les info du panier
        $stmt = $pdo->prepare("select identifiant, NomClient from panier");
        $stmt -> execute();
        $paniers = $stmt->fetchAll();
        foreach($paniers as $panier){
            Panier::$paniers[] = new Panier($panier['identifiant'], $panier['NomClient']);
        } 
    }

   public static function getFruitPanier($identifiant){
    $pdo = monPDO::getPDO();
    //Requête pour récupérer tous les fruits d'un panier
    $req ="select f.nom as fruit, f.poids as poids, f.prix as prix from panier p inner join fruit f on f.identifiant=p.identifiant where p.identifiant = :id";
    $stmt = $pdo->prepare($req);
    $stmt -> bindValue(":id", $identifiant, PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt->fetchAll();
    }

    public static function getNBPanierInDB(){
        $pdo = monPDO::getPDO();
        //Requête qui permet de compter le nb de panier dans la DB
        $req ="select count(*) as nbPanier from panier";
        $stmt = $pdo->prepare($req);
        $stmt -> execute();
        $resultat = $stmt->fetch();
        return $resultat['nbPanier'];
    }

    public static function insertIntoDB($identifiant, $nom){
        $pdo = monPDO::getPDO();
        //On utilise bindValue() pour sécuriser
        $req ="insert into panier (identifiant, NomClient) values (:id,:nom)";
        $stmt = $pdo->prepare($req);
        $stmt -> bindValue(":id",$identifiant, PDO::PARAM_INT);
        $stmt -> bindValue(":nom",$nom, PDO::PARAM_STR);
        //On encadre avec un try/catch pour attraper des erreurs s'il y en a
        //au moment de l'ajout
        try{
            return $stmt -> execute();
        } catch (PDOException $e){
            echo "Erreur: ". $e->getMessage();
            return false;
        }
    }

    //Fonction qui permet de récupérer tous les paniers
    public static function getPaniers(){
        $pdo = monPDO::getPDO();
        //On récupère l'identifiant et le nom client du panier
        $req ="select identifiant, NomClient from panier";
        $stmt = $pdo->prepare($req);
        $stmt -> execute();
        return $stmt->fetchAll();
    }

}
?>