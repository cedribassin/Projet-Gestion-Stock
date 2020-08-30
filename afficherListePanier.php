<?php 
require_once "classes/fruit.class.php";
require_once "classes/panier.class.php";
require_once "classes/monPDO.class.php";
require_once "classes/paniers.manager.php";
require_once "classes/fruits.manager.php";
require_once "classes/formatage.utile.php";
include("common/header.php");
include("common/menu.php");
?>
<div class="container">
<?php Utile::gestionTitreNiveau2("Liste paniers :");?>

<?php 
    //$_POST['type'] === "modification") => me permet de tester aussi qu'on est sur modification
    // sinon on essaierait de faire la même action sur les 2 boutons alors qu'on cherche à 
    // distinguer l'action de modification et celle de suppression
    if(isset($_POST['idFruit']) && $_POST['type'] === "modification"){
        $idFruitToUpdate = $_POST['idFruit'];
        $poidsFruitToUpdate = (int)$_POST['poidsFruit'];
        $prixFruitToUpdate = (int)$_POST['prixFruit'];
        $res = FruitManager::updateFruitDB($idFruitToUpdate, $poidsFruitToUpdate, $prixFruitToUpdate);
        if($res){
            echo '<div class="alert alert-success mt-2" role="alert">
            Modification(s) réalisée(s) avec succès!
          </div>';
        } else {
            echo '<div class="alert alert-danger mt-2" role="alert">
            Echec de la modification
            </div>';
              }
        } else if(isset($_POST['idFruit']) && $_POST['type'] === "supprimer"){
            $idFruitToUpdate = $_POST['idFruit'];
            $res = fruitManager::deleteFruitFromPanier($idFruitToUpdate);
            if($res){
                echo '<div class="alert alert-success mt-2" role="alert">La suppression réussie</div>';
            } else {
                echo '<div class="alert alert-danger mt-2" role="alert">Echec de la suppression</div>';
            }
        }
    //On rajoute dans une variable statique les info du paniers avec une fonction setPaniersFromDB()
    panierManager::setPaniersFromDB();

    //On réalise ensuite un affichage de nos paniers
    foreach(Panier::$paniers as $panier){
        $panier->setFruitToPanierFromDB();
        echo $panier;
    }
?>
</div>
<?php
    include("common/footer.php");
?>