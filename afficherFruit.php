<?php 
    require_once "classes/fruit.class.php";
    require_once "classes/panier.class.php";
    require_once "classes/monPDO.class.php";
    require_once "classes/fruits.manager.php";
    require_once "classes/formatage.utile.php";
    include("common/header.php");
    include("common/menu.php");
?>
<div class="container">
<?php $titreFruit = Utile::gestionTitreNiveau2("Fruits: ");
echo $titreFruit;
?>
<?php 

    if (isset($_POST['idPanier'])){
        $idFruit = $_POST['idFruit'];
        $idPanier = (int) $_POST['idPanier'];
        $res = FruitManager::updatePanierForFruitDB($idFruit, $idPanier);
        if($res){
            echo '<div class="alert alert-success mt-2" role="alert">
            Modification(s) réalisée(s) avec succès!
          </div>';
        } else {
            echo '<div class="alert alert-danger mt-2" role="alert">
            Echec de la modification
            </div>';
              }
    }

   FruitManager::setFruitFromDB();
  echo '<div class="row mx-auto">';
    foreach( Fruit::$fruits as $fruit){
        //pb => padding bottom
        echo '<div class="col-2 col-sm p-2">';
            //On utilise la fonction afficherListeFruit() pour mettre du style dans
            // l'affichage des fruits
            echo $fruit->afficherListeFruit();
        echo '</div>';
    }
    echo '</div>';
?>
</div>
<?php
    include("common/footer.php");
?>