<?php 
    require_once "classes/fruit.class.php";
    require_once "classes/panier.class.php";
    include("common/header.php");
    include("common/menu.php");


?>

<h2> Ajout d'un panier: </h2>
<?php 


echo '<form action="#" method ="POST" >';
echo '<fieldset><legend>Panier à créer :</legend>';
echo '<label for="nb_orange">Nombres oranges : </label>';
echo '<input type="number" name="nb_orange" id="nb_orange" required/>';
echo '<label for="nb_kiwi">Nombres de kiwis : </label>';
echo '<input type="number" name="nb_kiwi" id="nb_kiwi" required/>';
echo '<input type="submit" value="Créer le panier" />';
echo "</fieldset></form>";


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
    
    // On vérifie si le champs nb_orange est rempli
    if(isset($_POST['nb_orange'])){
        // Si le champs est rempli, on crée un nouveau panier
        $newPanier = new Panier();
        // On crée 2 variables pour récupérer le nb d'orange et de kiwi
        $nbOrange = (int)$_POST['nb_orange'];
        $nbKiwi = (int)$_POST['nb_kiwi'];
        //On boucle sur le nb de fruit
        for($i=0; $i<$nbOrange; $i++){
            //On crée le nb d'orange, et leur donne un poids aléatoire
            $newPanier -> addFruit(new Fruit(Fruit :: ORANGE, rand(100, 200)));
        }
        for($i=0; $i<$nbKiwi; $i++){
            $newPanier -> addFruit(new Fruit(Fruit :: KIWI, rand(50, 100)));
        }
        $listePaniers [] = $newPanier;
    }

     foreach($listePaniers as $listePanier){
        echo $listePanier;
    }  


    echo '<form action="#" method="POST">';
        echo'<label for="panier">Panier : </label>';
        echo '<select name="panier" id="panier" onChange="submit()">';
        echo'<option value=""></option>';
    foreach($listePaniers as $listePanier){
        echo "<option value='".$listePanier->getIdentifiant()."'>Panier n°".$listePanier->getIdentifiant()."</option>'";
    }
        echo'</select>';
    echo '</form>';

    if(isset($_POST['panier'])){ 
        $panierAAfficher = getPanierById((int)$_POST['panier']);
        echo "<h2>Affichage du panier: ".$_POST['panier']."</h2>";
        echo $panierAAfficher;
    } 

    function getPanierById($id){
        global $listePaniers;
        foreach($listePaniers as $panier){
            if($panier->getIdentifiant() === $id){
                return $panier;
            }
            
        }
    }
?>
<?php
    include("common/footer.php");
?>