<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarBairro {

    private $DadosId;

    public function apagarBairro($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $apagarBairro = new \App\adms\Models\AdmsApagarBairro();
            $apagarBairro->apagarBairro($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um bairro!</div>";
        }
        $UrlDestino = URLADM . 'bairro/listar';
        header("Location: $UrlDestino");
    }

}
