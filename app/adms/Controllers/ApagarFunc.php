<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarFunc {

    private $DadosId;

    public function apagarFunc($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarFunc = new \App\adms\Models\AdmsApagarFunc();
            $apagarFunc->apagarFunc($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: É necessário selecionar um Funcionário!</div>";
        }
        $UrlDestino = URLADM . 'funcionarios/listar-func';
        header("Location: $UrlDestino");
    }

}
