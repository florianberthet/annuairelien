<?php

include 'connexion.class.php';
include 'lien.class.php';

/*
 * Suppression du lien et retour a l'accueil
 */
Connexion::get()->query('DELETE FROM Lien WHERE id="' . $_GET['id'] . '"');
header('Location:index.php');