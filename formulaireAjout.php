<?php

include 'connexion.class.php';
include 'lien.class.php';

echo '<a href=".">Annuler</a>';

/*
 * On recherche si le lien a un id
 * S'il en a un on lui attibut ses paramêtre
 * Si non on les initialise a vide
 */
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $lien = (Lien::getInstanceLien($id));
    $lien = $lien[$id];
    $url = htmlentities($lien->getUrl());
    $titre = htmlentities($lien->getTitre());
    $description = htmlentities($lien->getDescription());
    $tag = htmlentities($lien->getTag());
} else {
    $url = "";
    $titre = "";
    $description = "";
    $id = "";
    $tag="";
}

/*
 * Formulaire permettant la création / modification des lien
 */
$html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
$html.='<form action="formulaireAjout.php" name="ajout" method="Post">';
$html.='Url : <input type="text" name="url" value="' . $url . '"><br/>';
$html.= '<input type="hidden" name="id"  value="' . $id . '">   ';
$html.='Titre : <input type="text" name="titre" value="' . $titre . '"><br/>';
$html.='Description : <input type="text" name="description" value="' . $description . '"><br/>';
$html.='Tag: <input type="text" name="tag" value="' . $tag. '"><br/>';

$html.='<input type="submit">';
$html.='</form>';

echo $html;


/*
 * On verifie la bonne reception des donnée 
 */
if (isset($_POST['url'], $_POST['titre'], $_POST['id'], $_POST['description'],$_POST['tag'])) {
    /*
     * On verifie si  le lien n'existe et on le créer 
     */
    if (empty($_POST['id'])) {
        $url = addslashes($_POST['url']);
        $titre = addslashes($_POST['titre']);
        $description = addslashes($_POST['description']);
        $tag = addslashes($_POST['tag']);
        $query = 'INSERT INTO Lien(url,titre,description,tag) values("' . $url . '","' . $titre . '","' . $description . '","'.$tag.'" )';
        $result = Connexion::get()->exec($query);
    }
    /*
     * Si le lien existe on effectue les modification 
     */ else {
        $lien = Lien::getInstanceLien($_POST['id']);
        $lien = $lien[$_POST['id']];
        $lien->setTitre($_POST['titre']);
        $lien->setUrl($_POST['url']);
        $lien->setDescription($_POST['description']);
        $lien->setTag($_POST['tag']);
    }
    header('Location:index.php');
}
        
        