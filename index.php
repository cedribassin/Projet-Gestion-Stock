
<?php 
    require_once "classes/formatage.utile.php";
    include("common/header.php");
    include("common/menu.php");
?>
  <!-- On utilise la classe container -> CF doc bootstrap -->
<div class="container">
<?php 
    echo Utile:: gestionTitreNiveau1("Bienvenue sur l'application de gestion de stock");
?>
<div class="row">
    <div class="col">
      <h2 class="text-center">Gestion des paniers</h2>
      <!--mx-auto me permet de centrer le bouton dans ma colonne -->
      <div class="mx-auto" style="width:200px"><a class="btn btn-outline-primary" href="afficherListePanier.php" role="button">Gestion des paniers</a></div>
    </div>
    <div class="col">
    <h2 class="text-center">Gestion des fruits</h2>
    <div class="mx-auto" style="width:200px"><a class="btn btn-outline-primary" href="afficherFruit.php" role="button">Gestion des fruits</a>
    </div>
  </div>
</div>
<?php 
    include("common/footer.php");
?>