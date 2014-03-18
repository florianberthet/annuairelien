<?php

include 'connexion.class.php';
include 'lien.class.php';
echo '<a href=".">Retour</a>';

/*
 * formulaire de la recherche
 */
$html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
$html.='<form action="recherche.php" name="recherche" method="GET">';
$html.='Rechercher <input type="text" name="recherche" value=""><br/>';

$html.='<input type="submit">';
$html.='</form>';

echo $html;

/*
 * On verifie que le formulaire de recherche soit rempli
 */
if (isset($_GET['recherche']) OR isset($_GET['r'])) {

    /*
     * On recupere tout les lien contenant le terme recherché
     */
    if (isset($_GET['recherche'])) {//recheche global
        $recherche = addslashes($_GET['recherche']);
        $query = 'SELECT * FROM Lien WHERE url Like "%' . $recherche . '%"OR titre LIKE "%' . $recherche . '%" OR description LIKE "%' . $recherche . '%" OR tag LIKE "%' . $recherche . '%" ';
        $results = Connexion::get()->query($query);
    } elseif (isset($_GET['r'])) {//recherche par tag
        $recherche = addslashes($_GET['r']);
        $query = 'SELECT * FROM Lien WHERE tag = "' . $recherche . '" ';
        $results = Connexion::get()->query($query);
    }
    /*
     * On previens l'utilisateur s'il n'y a aucun resultat 
     */
    if (empty($results)) {
        $html2 = 'Aucun resultat pour ' . $recherche;
    } else {
        $html2 = "";
        /*
         * On affiche les liens
         */
        foreach ($results as $result) {
            $html2 .= "<h1>" . $result["titre"] . "</h1>";
            $html2.="Url : " . $result['url'] . "<br/>";
            $html2.=$result["description"] . "<br/>";
            $html2.="publiée le : " . $result["date"];
            $html2.='<br/><a href="formulaireAjout.php?id=' . $result['id'] . '">Modifier</a>  ';
            $html2.='  <a href="supprimer.php?id=' . $result['id'] . '">Supprimer</a>';
        }
    }
    echo $html2;
}