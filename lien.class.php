<?php

class Lien {


    private static $instanceLien = null;
    private $id;
    private $url;
    private $titre;
    private $description;
    private $date;
    private $tag ;

    static function getInstanceLien($id) {


        if (is_null(self::$instanceLien[$id])) {

            self::$instanceLien[$id] = new Lien($id);
        }

        return self::$instanceLien;
    }

    function __construct($id) {
        $this->id = $id;
        $lien = Connexion::get()->query('SELECT *  FROM Lien  WHERE id =' . $this->id);
        $this->lien = $lien;
        $this->url = $this->lien[0]["url"];
        $this->titre = $this->lien[0]["titre"];
        $this->description = $this->lien[0]["description"];
        $this->date = $this->lien[0]["date"];
        $this->tag = $this->lien[0]["tag"];
    }

    /*
     * Affichage de l'url
     */

    public function getUrl() {
        return $this->url;
    }

    /*
     * mofication de l'url
     */

    public function setUrl($url) {
        $url = addslashes($url);
        $this->url = Connexion::get()->query('UPDATE Lien SET url="' . $url . '"  WHERE id="' . $this->id . '"');
    }

    /*
     * Affichage du titre
     */

    public function getTitre() {
        return $this->titre;
    }

    /*
     * Modification du titre
     */

    public function setTitre($titre) {
        $titre = addslashes($titre);
        $this->titre = Connexion::get()->exec('UPDATE Lien SET titre="' . $titre . '"  WHERE id="' . $this->id . '"');
    }

    /*
     * Affichage de la description
     */

    public function getDescription() {
        return $this->description;
    }

    /*
     * Modification de la description
     */

    public function setDescription($description) {
        $description = addslashes($description);
        $this->description = Connexion::get()->query('UPDATE Lien SET description="' . $description . '"  WHERE id="' . $this->id . '"');
    }

    /*
     * Affichage de la date
     */

    public function getDate() {
        return $this->date;
    }

    /*
     * Recuperation des tous les liens
     */

    static function getAll($order = null) {
        $query = 'select * from Lien';
        
        if (!is_null($order)) {
            $query.=' order by ' . $order.' DESC';
        }
        return Connexion::get()->query($query);
    }

    /*
     * Affichage de tous les lien
     */

    static function afficherLiens() {
        /*
         * Lien vers ajout d'un lien
         */
        $html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        $html .= 'Il y a actuellement : ' . Lien::nbLien() . ' liens sur le site.<br/>';
        $html .= "<a href=recherche.php>Recherher un lien </a><br/>";
        $html .= "<a href=formulaireAjout.php>Ajouter un lien </a>";
        $liens = self::getAll('date');
        foreach ($liens as $lien) {
            $html.="<h1>" . htmlentities($lien["titre"]) . "</h1>";
            $html.="Url : <a href=http://". htmlentities($lien['url']) . ">".htmlentities($lien['url'])."</a><br/>";
            $html.=htmlentities($lien["description"]) . "<br/>";
            $html.="publiée le : " . $lien["date"];
            $html.='<br/>Tags :<a href="recherche.php?r='.htmlentities($lien['tag']).'">'.htmlentities($lien['tag']).'</a>';
                $html.='<br/><a href="formulaireAjout.php?id=' . $lien['id'] . '">Modifier</a>  ';
            $html.='  <a href="supprimer.php?id=' . $lien['id'] . '">Supprimer</a>';
        }
        return $html;
    }

    static function nbLien() {
        $liens = self::getAll();
        $liens = sizeof($liens);
        return $liens;
    }

    
    public function getTag(){
                    
            return $this->tag;
    }
    
    
    public function setTag($tag){
        
        $tag = addslashes($tag);
        $this->description = Connexion::get()->query('UPDATE Lien SET tag="' . $tag . '"  WHERE id="' . $this->id . '"');
        
        }
}