<?php
require_once "classes/paniers.manager.php";
require_once "classes/formatage.utile.php";

class Panier {

    public static $paniers = [];
    //Variable qui permettra d'avoir un identifiant unique pour chaque panier
    //private static $prochainIdentifiant = 1; => on le retire car on passe maintenant par une BD

    //Variable qui permettra d'identifier chaque panier
    private $identifiant;
    private $nomClient;
    private $oranges = [];
    private $kiwis = [];

    // Constructeur utilisé avant l'affichage de la liste des paniers
    /* public function __construct(){
        //A chaque fois que l'on crée un panier, on veut qu'il est un nouvel
        // id qui prend une valeur unique
         $this -> identifiant = self::$prochainIdentifiant;
        self :: $prochainIdentifiant ++; 
    } */

    // On veut afficher l'identifiant et le nom du client
    public function __construct($identifiant, $nomClient){
       $this->identifiant=$identifiant;
       $this->nomClient=$nomClient;
    }

    public function getIdentifiant(){
        return $this->identifiant;
    } 

    //Fonction qui permet d'ajouter un fruit
    /* public function addFruit($fruit){
        if($fruit->getnom() === Fruit::ORANGE){
           $this -> oranges[] = $fruit;
        } else if ($fruit->getnom() === Fruit::KIWI){
           $this -> kiwis[] = $fruit;
        }
    } */

    //Fonction qui permet d'ajouter un panier
    public function setFruitToPanierFromDB(){
        //On veut récupérer tous les fruits du paniers
        $fruits = panierManager::getFruitPanier($this->identifiant);
       
        foreach($fruits as $fruit){
            if(preg_match("/orange/", $fruit['fruit'])){
                $this->oranges[] = new Fruit($fruit['fruit'], $fruit['poids'], $fruit['prix']);
            } else if(preg_match("/kiwi/",  $fruit['fruit'])){
                $this->kiwis[] = new Fruit($fruit['fruit'], $fruit['poids'], $fruit['prix']);
            }
        }
    }

    public function __toString(){
        $affichage = Utile::gestionTitreNiveau2('Voici le contenu du panier ' .$this->identifiant.' :');
        $affichage .= '<table class="table">';
            $affichage .= '<thead>';
                $affichage .= '<tr>';
                    $affichage .= '<th scope="col">Image</th>';
                    $affichage .= '<th scope="col">Nom</th>';
                    $affichage .= '<th scope="col">Poids</th>';
                    $affichage .= '<th scope="col">Prix</th>';
                    $affichage .= '<th scope="col">Modifier</th>';
                    $affichage .= '<th scope="col">Supprimer</th>';
                $affichage .= '</tr>';
            $affichage .= '</thead>';
        $affichage .= '<tbody>';
        foreach($this->oranges as $orange){
            $affichage .= $this->affichageOptimiseFruit($orange);
          /*   $affichage .= '<tr>';
                $affichage .= '<td>'.$orange->getAffichageSmallImg().'</td>';
                $affichage .= '<td>'.$orange->getNom().'</td>';
                $affichage .= '<td>'.$orange->getPoids().'</td>';
                $affichage .= '<td>'.$orange->getPrix().'</td>';
                $affichage .= '<td><button type="button" class="btn btn-primary">Modifier</button></td>';
                $affichage .= '<td><button type="button" class="btn btn-danger">Supprimer</button></td>';
            $affichage .= '</tr>'; */
        }
        foreach($this->kiwis as $kiwi){
            $affichage .= $this->affichageOptimiseFruit($kiwi);
        }
        $affichage .= '</tbody>';
        $affichage .= '</table>';
        return $affichage;
    }
        
    // affichageOptimiseFruit($fruit) = Fonction qui va permettre l'affichage des fruits dans nos tables en évitant de duppliquant le code iniatiale:
    /* foreach($this->kiwis as $kiwi){
            $affichage .= '<tr>';
                $affichage .= '<td>'.$kiwi->getAffichageSmallImg().'</td>';
                $affichage .= '<td>'.$kiwi->getNom().'</td>';
                $affichage .= '<td>'.$kiwi->getPoids().'1</td>';
                $affichage .= '<td>'.$kiwi->getPrix().'</td>';
                $affichage .= '<td><button type="button" class="btn btn-primary">Modifier</button></td>';
                $affichage .= '<td><button type="button" class="btn btn-danger">Supprimer</button></td>';
            $affichage .= '</tr>';
        }
        */
    private function affichageOptimiseFruit($fruit){
        $affichage = '<tr>';
            $affichage .= '<td>'.$fruit->getAffichageSmallImg().'</td>';
            $affichage .= '<td>'.$fruit->getNom().'</td>';
            $affichage .= '<td>';
                //Si on a cette info "?idFruit=orange1" dans notre url, on rajoute alors un formulaire
                // $_GET['idFruit'] === $fruit->getNom() permet de vérifier qu'on soit bien sur la même ligne
                if(isset($_GET['idFruit']) && $_GET['idFruit'] === $fruit->getNom()){
                    $affichage .= '<form action"#" method="POST">';//=>Début formulaire avec POST
                    $affichage .='<input type="hidden" name="type" id="type" value="modification" />';
                        $affichage .='<input type="hidden" name="idFruit" id="idFruit" value="'.$fruit->getNom().'" />';
                        $affichage .='<input type="number" name="poidsFruit" id="poidsFruit" value="'.$fruit->getPoids().'" />'; 
                }
                //Sinon on fait ce qu'on faisait avant
                else{
                    $affichage .=$fruit->getPoids();
                }
            $affichage .='</td>';
            $affichage .= '<td>';
            if(isset($_GET['idFruit']) && $_GET['idFruit'] === $fruit->getNom()){
                    $affichage .='<input type="number" name="prixFruit" id="prixFruit" value="'.$fruit->getPrix().'" />'; 
            }
            else{
                $affichage .=$fruit->getPrix();
            }
            $affichage .= '</td>';
            //On crée un formulaire pour pouvoir modifier ou supprimer nos fruits
            $affichage .= '<td>';
            if(isset($_GET['idFruit']) && $_GET['idFruit'] === $fruit->getNom()){
                $affichage .='<input class="btn btn-success" type="submit" value="Valider" />';
                $affichage .= '</form>';//=>fin formulaire avec POST
            } else {
                $affichage .='<form action"#" method="GET">';
                //Quand on clique sur le button, il y a l'id du fruit qui est passé ds l'url
                $affichage .='<input type="hidden" name="idFruit" id="idFruit" value="'.$fruit->getNom().'" />';
                //Si on avait mis 'button' à la place de 'submit', on aurait été obligé d'utiliser une fonction
                // Js pour valider le formulaire, ici submit valide directement le formulaire
                $affichage .='<input class="btn btn-primary" type="submit" value="Modifier" />';
            $affichage .='</form>';
            }
               
            $affichage .= '</td>';
            $affichage .= '<td>';
                $affichage .='<form action"#" method="POST">';
                $affichage .='<input type="hidden" name="idFruit" id="idFruit" value="'.$fruit->getNom().'" />';
                $affichage .='<input type="hidden" name="type" id="type" value="supprimer" />';
                $affichage .='<input class="btn btn-danger" type="submit" value="Supprimer" />';
                $affichage .='</form>';
            $affichage .= '</td>';
        $affichage .= '</tr>';
        return $affichage;
    }
        /* if($fruit->getnom() === Fruit::ORANGE){
           $this -> oranges[] = $fruit;
        } else if ($fruit->getnom() === Fruit::KIWI){
           $this -> kiwis[] = $fruit;
        } */
    
    //Fonction pour générer un id unique.
    //A noter que l'idéal était de l'autoincrement dans la BD -> en faisant 
    //comme ça il ne faudra pas permettre d'effacer un panier dans la BD
    //Pour générer un ID unique on aurait aussi pu utiliser la fonction timeStamp()
    public static function generateUniqueId(){
        return PanierManager::getNBPanierInDB() + 1;
    }

    public function addFruit($fruit){
        if(preg_match("/orange/", $fruit->getNom())){
            //Si c'est une orange, on la rajoute dans le fruit dans le tableau d'orange
            $this->oranges[] = $fruit;
        }
        else if(preg_match("/kiwi/", $fruit->getNom())){
            //idem pour kiwi
            $this->kiwis[] = $fruit;
        }
    }

    //Fonction qui permettra de sauvegarder dans la DB directement
    public function saveInDB(){
        //Dans insertIntoDB() on envoie les info d'identifiant et non client
       return PanierManager::insertIntoDB($this->identifiant, $this->nomClient);
    }

    //Fonction pour afficher mon panier
  /*   public function __toString(){
        $affichage = "Mon panier n°" .$this->identifiant." contient: <br/>";
        foreach($this->oranges as $orange){
            $affichage .= $orange;
        }
        foreach($this->kiwis as $kiwi){
            $affichage .=  $kiwi;
        }
        echo "<br>----------------------</br>";
        return $affichage;
    } */

}

?>