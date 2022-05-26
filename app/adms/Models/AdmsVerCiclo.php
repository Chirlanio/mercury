<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerCiclo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerCiclo {

    private $Resultado;
    private $DadosId;

    public function verCiclo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verCiclo = new \App\adms\Models\helper\AdmsRead();
        $verCiclo->fullRead("SELECT c.*
                FROM adms_ciclos c
                WHERE c.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCiclo->getResultado();
        return $this->Resultado;
    }

}
