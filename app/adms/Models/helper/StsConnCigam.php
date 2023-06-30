<?php

namespace Sts\Models\helper;

use PDO;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsConnCigam
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class StsConnCigam {

    public static $Host = HOSTCIGAM;
    public static $User = USERCIGAM;
    public static $Pass = PASSCIGAM;
    public static $Dbname = DBNAMECIGAM;
    private static $Connect = null;

    private function conectar() {
        try {
            if (self::$Connect == null) {
                self::$Connect = new PDO('pgsql:host=' . self::$Host . ';dbname=' . self::$Dbname, self::$User, self::$Pass);
            }
        } catch (Exception $ex) {
            echo 'mensagem: ' . $ex->getMessage();
            die;
        }
        return self::$Connect;
    }

    public function getConn() {
        return self::conectar();
    }

}
