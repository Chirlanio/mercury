<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarLoja
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarLoja {

    private $DadosId;

    public function apagarLoja($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarLoja = new \App\adms\Models\AdmsApagarLoja();
            $apagarLoja->apagarLoja($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma loja!</div>";
        }
        $UrlDestino = URLADM . 'lojas/listarLojas';
        header("Location: $UrlDestino");
    }

}
