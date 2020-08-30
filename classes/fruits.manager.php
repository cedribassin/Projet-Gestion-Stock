<?php

require_once "classes/fruit.class.php";
require_once "classes/monPDO.class.php";

class FruitManager{

    public static function setFruitFromDB(){
        $pdo = monPDO::getPDO();
        $stmt = $pdo->prepare("select f.nom as Nom, f.poids as Poids, f.prix as Prix from fruit f");
        $stmt -> execute();
        $fruits = $stmt->fetchAll();
        foreach($fruits as $fruit){
            Fruit::$fruits[] = new fruit($fruit['Nom'], $fruit['Poids'], $fruit['Prix']);
            //On utilise ici la fonction preg_match() pour tester sur le nom dans le but d'afficher la bonne image
            /* if(preg_match("/orange/", $fruit['Nom'])){
                echo "<img class='sizeImage' src='sources/images/orange.png' alt='image orange'></br>";
            }
            if(preg_match("/kiwi/", $fruit['Nom'])){
                echo "<img class='sizeImage' src='sources/images/kiwi.png' alt='image orange'></br>";
            }
            echo "Nom: ". $fruit['Nom']. "</br>";
            echo "Poids: ". $fruit['Poids']. "</br>";
            echo "Prix: ".$fruit['Prix']. "</br>";
            echo "<br>-----------------------</br>";
    */
        } 
    }

    public static function getNBFruitInDB(){
        $pdo = monPDO::getPDO();
        //Requête qui permet de compter le nb de panier dans la DB
        $req ="select count(*) as nbFruit from fruit";
        $stmt = $pdo->prepare($req);
        $stmt -> execute();
        $resultat = $stmt->fetch();
        return $resultat['nbFruit'];
    }

    public static function insertIntoDB($nom, $poids, $prix, $idPanier){
        $pdo = monPDO::getPDO();
        //On utilise bindValue() pour sécuriser
        //Dans la mesure ou on insert toutes les variables, on est pas obligé de faire
        //la syntaxe suivante: insert into fruit (Nom, Poids, Prix, identifiant) values (:nom, :pds, :prx, idPanier)
        //on met directement les values:
        $req ="insert into fruit values (:nom, :pds, :prx, :idPanier)";
        $stmt = $pdo->prepare($req);
        $stmt -> bindValue(":nom",$nom, PDO::PARAM_STR);
        $stmt -> bindValue(":pds",$poids, PDO::PARAM_INT);
        $stmt -> bindValue(":prx",$prix, PDO::PARAM_INT);
        $stmt -> bindValue(":idPanier",$idPanier, PDO::PARAM_INT);

        //On encadre avec un try/catch pour attraper des erreurs s'il y en a
        //au moment de l'ajout
        try{
            return $stmt -> execute();
        } catch (PDOException $e){
            echo "Erreur: ". $e->getMessage();
            return false;
        }
    }

    //Fonction qui permet les modifications en bdd
    public static function updateFruitDB($idFruitToUpdate, $poidsFruitToUpdate, $prixFruitToUpdate){
        $pdo = monPDO::getPDO();
        $req ="update fruit set Poids=:poids, Prix=:prix where nom = :id";
        $stmt = $pdo->prepare($req);
        $stmt -> bindValue(":id",$idFruitToUpdate, PDO::PARAM_STR);
        $stmt -> bindValue(":poids",$poidsFruitToUpdate, PDO::PARAM_INT);
        $stmt -> bindValue(":prix",$prixFruitToUpdate, PDO::PARAM_INT);
        try{
            return $stmt -> execute();
        } catch (PDOException $e){
            echo "Erreur: ". $e->getMessage();
            return false;
        }

    }

    //Fonction qui permet les suppressions en bdd
    // Il ne s'agit pas d'une vrai suppression mais on supprime l'association entre
    // le fruit et le panier
    public static function deleteFruitFromPanier($idFruitToUpdate){
        $pdo = monPDO::getPDO();
        $req = "update fruit set identifiant = null where nom = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id", $idFruitToUpdate, PDO::PARAM_STR);
        try{
            return $stmt->execute();
        } catch (PDOException $e){
            echo "Erreur : ". $e->getMessage();
            return false;
        }
    }

    public static function getPanierFromFruit($nom){
        $pdo = monPDO::getPDO();
        //Requête qui permet le nom du client
        $stmt = $pdo->prepare("Select p.identifiant as Client from fruit f inner join panier p on f.identifiant = p.identifiant where f.nom = :nom");
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        $stmt -> execute();
        $client = $stmt->fetch();
        return $client['Client'];
    }

    public static function updatePanierForFruitDB($idFruit, $idPanier){
        $pdo = monPDO::getPDO();
        $req = "update fruit set identifiant = :idPanier where nom = :idFruit";
        $stmt = $pdo->prepare($req);
        //ATTENTION si on met PARAM_INT pour $idFruit, un changement de nom sur un 
        // fruit sera attribué sur tous les fruits!
        $stmt->bindValue(":idFruit", $idFruit, PDO::PARAM_STR);
        $stmt->bindValue(":idPanier", $idPanier, PDO::PARAM_INT);
        try{
            return $stmt->execute();
        } catch (PDOException $e){
            echo "Erreur : ". $e->getMessage();
            return false;
        }
    }

}

?>