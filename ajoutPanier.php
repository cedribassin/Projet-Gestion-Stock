<?php 
    require_once "classes/fruit.class.php";
    require_once "classes/panier.class.php";
    require_once "classes/formatage.utile.php";
    include("common/header.php");
    include("common/menu.php");


?>
<div class="container">
<?php 
echo Utile::gestionTitreNiveau2("Ajout d'un panier: ");
    echo '<form action="#" method ="POST" >';
        echo '<div class="row">';
            echo '<div class="col">';
                echo '<label for="client">Nom du client : </label>';
                echo '<input class="form-control"  type="text" name="client" id="client" required/>';    
             echo '</div>';
             echo '<div class="col">';
                echo '<label for="nb_orange">Nombres oranges : </label>';
                echo '<input type="number" name="nb_orange" id="nb_orange" required/>';
            echo '</div>';
            echo '<div class="col">';
                echo '<label for="nb_kiwi">Nombres de kiwis : </label>';
                echo '<input type="number" name="nb_kiwi" id="nb_kiwi" required/>';
            echo '</div>';
            echo '<input class="btn btn-primary" type="submit" value="Créer le panier" />';
        echo '</div>';
    echo "</form>";


    //Rappel: isset vérifie qu'une variable est bien définie et empty qu'elle n'est pas nulle
    if(isset($_POST['client']) && !empty($_POST['client'])){
        $newPanier = new Panier(Panier::generateUniqueId(), $_POST['client']);
        $res = $newPanier->saveInDB();
        if($res){
                // On crée 2 variables pour récupérer le nb d'orange et de kiwi
            $nbOrange = (int)$_POST['nb_orange'];
            $nbKiwi = (int)$_POST['nb_kiwi'];
            $cpt=1;
            $nbFruitInDB = Fruit :: genererUniqueID();
            //On boucle sur le nb de fruit
            for($i=0; $i<$nbOrange; $i++){
                //On génère un unique ID pour le fruit
                $fruit = new Fruit("orange".($nbFruitInDB + $cpt), rand(100, 200),20);
                //On l'enregistre en BD
                $fruit->saveInDB($newPanier->getIdentifiant());
                //Dans addFruit, on rajoute le fruit qu'on a crée
                $newPanier -> addFruit($fruit);
                $cpt++;
            }
            for($i=0; $i<$nbKiwi; $i++){
                $fruit = new Fruit("kiwi".($nbFruitInDB + $cpt), rand(100, 200),20);
                $fruit->saveInDB($newPanier->getIdentifiant());
                $newPanier -> addFruit($fruit);
                $cpt++;
            }
                echo $newPanier;
                echo "ok";
            } else {
                echo "L'ajout n'a pas fonctionné";
            }
        //echo $newPanier;
        /* $newPanier = new Panier();
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
        $listePaniers [] = $newPanier; */
    }  
?>
</div>

<?php
    include("common/footer.php");
?>