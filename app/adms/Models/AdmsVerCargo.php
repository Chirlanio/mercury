<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerCargo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerCargo {

    private $Resultado;
    private $DadosId;

    public function verCargo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verCargo = new \App\adms\Models\helper\AdmsRead();
        $verCargo->fullRead("SELECT * FROM tb_cargos 
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCargo->getResultado();
        return $this->Resultado;
    }

}
