<?php

/**
 * Description of class_connexion
 *
 * @author usig
 */
class Connexion extends PDO {

    private static $instance = null;

    function __construct() {
        $dsn = 'mysql:dbname=annuaire_lien;host=127.0.0.1';
        $user = 'root';
        $password = 'pwsio';

        try {
            parent::__construct($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
        $this->exec('SET NAMES \'UTF8\'');
    }

    static function get() {
        if (is_null(self::$instance)) {
            self::$instance = new Connexion();
        }
        return self::$instance;
    }

    function query($query) {
        $result = parent::query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    function table($table) {
        return $this->query('select * from ' . $table);
    }

    function queryFirst($query) {
        $query.=' limit 0,1 ';
        $result = $this->query($query);
        return $result[0];
    }

    public function queryConstruct($id, $table) {
        $query = 'SELECT * FROM ' . $table . ' WHERE id=' . $id;
        return $this->queryFirst($query);
    }

}
