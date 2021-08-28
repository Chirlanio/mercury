<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerCor
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerCor {

    private $Resultado;
    private $DadosId;

    public function verCor($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verCor = new \App\adms\Models\helper\AdmsRead();
        $verCor->fullRead("SELECT * FROM adms_cors 
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCor->getResultado();
        return $this->Resultado;
    }

}
