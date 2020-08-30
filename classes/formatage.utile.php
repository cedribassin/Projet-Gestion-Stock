<?php
//On crée une classe qui contiendra des fonctions statiques qui mettront en forme les pages
// => ce sera plus facile de gérer les formes

class Utile{

    //Fonction qui permettra de gérer les titres de niveau 2, elle prends un texte en paramètre
    public static function gestionTitreNiveau2($titre){
        return '<h2 class="persoBackgroundColorBlueLight text-white p-2 mt-2 rounded-lg border border-dark">'.$titre.'</h2>';
    }

    public static function gestionTitreNiveau1($titre){
        return '<h1 class="persoBackgroundColorBlueLight text-white p-2 mt-2 rounded-lg border border-dark">'.$titre.'</h1>';
    }

}

?>