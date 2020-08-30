<?php 
require_once "classes/fruit.class.php";
require_once "classes/panier.class.php";
include("common/header.php");
include("common/menu.php");


?>

<h2> Paniers : </h2>
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


/* echo "<pre>";
print_r($panier1);
echo "</pre>"; */

echo $panier1;
echo $panier2;

/* 
$tableauDeFruit = [$orange1, $orange2, $orange3, $kiwi1, $kiwi2, $kiwi3];

foreach($tableauDeFruit as $fruit){
    echo $fruit;
    echo "<br>----------------------</br>";
} */
?>
<?php
    include("common/footer.php");
?>