<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'connexion.class.php';
        include 'lien.class.php';
        /*
         * On afficher tous les lien
         */
        echo Lien::afficherLiens();
        ?>
    </body>
</html>
