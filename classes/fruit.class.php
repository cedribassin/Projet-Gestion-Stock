<?php
require_once "classes/fruits.manager.php";

class Fruit {

    private $nom;
    private $poids;
    private $prix;

    public static $fruits = [];

    //Constructeur
    function __construct($nom, $poids, $prix){
        $this -> nom = $nom;
        $this -> poids = $poids;
        $this -> prix = $prix;
    }
// Getter
public function getNom(){
    return $this->nom;
}
public function getPoids(){
    return $this->poids;
}
public function getPrix(){
    return $this->prix;
}
//Fonction qui permet de récupérer l'image en fonction du nom
 private function getAffichageImg(){
    if(preg_match("/orange/", $this->nom)){
        return "<img class='sizeImage mx-auto' src='sources/images/orange.png' alt='image orange'></br>";
    }
    if(preg_match("/kiwi/",  $this->nom)){
        return "<img class='sizeImage mx-auto' src='sources/images/kiwi.png' alt='image kiwi'></br>";
    }
} 

//Fonction identique à getAffichageImg() mais avec tailles d'images différentes
public function getAffichageSmallImg(){
    if(preg_match("/orange/", $this->nom)){
        return "<img class='mx-auto' style='width:75px' src='sources/images/orange.png' alt='image orange'></br>";
    }
    if(preg_match("/kiwi/",  $this->nom)){
        return "<img class='mx-auto' style='width:100px' src='sources/images/kiwi.png' alt='image kiwi'></br>";
    }
} 

//La fonction __toString() permet d'afficher directement des objets
// On peut faire un echo sur un objet que si il y a la fonction toString()
public function __toString(){
    $affichage = $this -> getAffichageImg();
    $affichage .= "Nom : " .$this-> nom ."<br />";
    $affichage .= "Poids : " .$this-> poids ."<br />";
    $affichage .= "Prix : " .$this-> prix ."<br />";
    return $affichage;
}

//Fonction qui permet de styliser l'affichage des fruits (idem que la fonction  __toString() )
public function afficherListeFruit(){
    // Code initial récupéré sur bootstrap, qui va être utilisé dans la fonction
   /* <div class="card" style="width: 18rem;">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>*/
    $affichage = '<div class="card">';
    $affichage .= $this -> getAffichageImg();
    $affichage .= '<div class="card-body">';
        $affichage .= '<h5 class="card-title">Nom : ' .$this->nom .'</h5>';
        $affichage .= '<p class="card-text">Poids : ' .$this->poids .'</br>';
        $affichage .= "Prix : " .$this->prix .'</br>';
        $affichage .= "Panier : ";
        $paniers = PanierManager::getPaniers();
        $panierFruit = FruitManager::getPanierFromFruit($this->nom);
        $affichage .='<form action="#" method="POST">';
            $affichage .= '<input type="hidden" name="idFruit" id="idFruit" value="'.$this->nom.'" />';
            $affichage .= '<select name="idPanier" id="idPanier" class="form-control form-control-sm" onChange="submit()">';
                //Cette balise vide permet d'avoir des fruits non assignés qui s'affichent
                //On peut ainsi les réatttibuer à quelqu'un
                $affichage .='<option value=""></option>';
                foreach($paniers as $panier){                           
                    if($panierFruit === $panier['identifiant']){
                        $affichage .='<option value="'.$panier['identifiant'].'" selected>'.$panier['NomClient'].'</option>';
                    } else {
                        $affichage .='<option value="'.$panier['identifiant'].'">'.$panier['NomClient'].'</option>';
                    }
                }
                $affichage .= '</select>';
            $affichage .= '</form>';
        $affichage .= "</p>";
    $affichage .= '</div>';
$affichage .= '</div>';
return $affichage;
}

public static function genererUniqueId(){
    return FruitManager::getNBFruitInDB() + 1;
}

public function saveInDB($idPanier){
        //Dans insertIntoDB() on envoie les info d'identifiant et non client
       return FruitManager::insertIntoDB($this->nom, $this->poids, $this->prix, $idPanier);
}

}