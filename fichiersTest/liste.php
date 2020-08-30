<?php 
    require_once "classes/fruit.class.php";
    require_once "classes/panier.class.php";
    include("common/header.php");
    include("common/menu.php");


?>

<h2> Liste : </h2>
<?php 
    $orange1 = new Fruit(Fruit :: ORANGE, 150);
    $orange2 = new Fruit(Fruit :: ORANGE, 130);
    $orange3 = new Fruit(Fruit :: ORANGE, 140);
    $kiwi1 = new Fruit(Fruit :: KIWI, 20);
    $kiwi2 = new Fruit(Fruit :: KIWI, 35);
    $kiwi3 = new Fruit(Fruit :: KIWI, 25);

    $panier1 = new Panier();
    $panier1 -> addFruit($orange1);
    $panier1 -> addFruit($orange2);
    $panier1 -> addFruit($kiwi1);

    $panier2 = new Panier();
    $panier2 -> addFruit($orange1);
    $panier2 -> addFruit($orange3);
    $panier2 -> addFruit($kiwi1);
    $panier2 -> addFruit($kiwi2);

    $listePaniers = [$panier1, $panier2];

    echo '<form action="#" method="POST">';
        echo'<label for="panier">Panier : </label>';
        echo '<select name="panier" id="panier" onChange="submit()">';
            echo'<option value=""></option>';
    foreach($listePaniers as $listePanier){
        echo "<option value='".$listePanier->getIdentifiant()."'>Panier n°".$listePanier->getIdentifiant()."</option>'";
    }
        echo'</select><br/>';
    echo '</form>';

    if(isset($_POST["panier"])){ 
        // On crée une variable $panierAAfficher qui contiendra le panier à afficher
        // On crée une fonction getPanierById() qui aura pour objectif de récupérer
        // le panier choisi
        // On caste en int car sinon le === de '$panier->getIdentifiant() === $id'
        // ne fonctionnera pas car $_POST["panier"] est une chaine de caractères et $id un int
        $panierAAfficher = getPanierById((int)$_POST["panier"]);
        echo "<h2>Affichage du panier: ".$_POST["panier"]."</h2>";
        echo $panierAAfficher;
    } 

    function getPanierById($id){
        global $listePaniers;
        foreach($listePaniers as $panier){
            //On vérifie l'id sur chaque panier ou on va boucler, et si on le trouve
            // on le renvoie
            if($panier->getIdentifiant() === $id){
                return $panier;
            }
            
        }
    }
?>
<?php
    include("common/footer.php");
?>