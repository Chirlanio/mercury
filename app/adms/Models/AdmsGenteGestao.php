<?php

namespace App\adms\Models;

If (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsGenteGestao
 *
 * @author Chirlanio
 */
class AdmsGenteGestao {

    private $Resultado;

    public function listar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT * FROM adms_gente_gestao");
        $this->Resultado = $listar->getResult();
        return $this->Resultado;
    }

}
