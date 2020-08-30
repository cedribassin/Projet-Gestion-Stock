<?php 
require_once "classes/fruit.class.php";
include("common/header.php");
include("common/menu.php");


?>

<h2> Fruits : </h2>
<?php 
$orange1 = new Fruit(Fruit :: ORANGE, 150);
$orange2 = new Fruit(Fruit :: ORANGE, 130);
$orange3 = new Fruit(Fruit :: ORANGE, 140);
$kiwi1 = new Fruit(Fruit :: KIWI, 20);
$kiwi2 = new Fruit(Fruit :: KIWI, 35);
$kiwi3 = new Fruit(Fruit :: KIWI, 25);

$tableauDeFruit = [$orange1, $orange2, $orange3, $kiwi1, $kiwi2, $kiwi3];

foreach($tableauDeFruit as $fruit){
    echo $fruit;
    echo "<br>----------------------</br>";
}
?>
<?php
    include("common/footer.php");
?>