<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerPerfil
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerPerfil {

    private $Resultado;

    public function verPerfil() {
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_usuarios WHERE id =:id LIMIT :limit", "id=" . $_SESSION['usuario_id'] . "&limit=1");
        $this->Resultado = $verPerfil->getResult();
        return $this->Resultado;
    }

}
