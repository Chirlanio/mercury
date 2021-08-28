<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarTroca
{

    private $DadosId;

    public function apagarTroca($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarTroca = new \App\adms\Models\AdmsApagarTroca();
           $apagarTroca->apagarTroca($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um item!</div>";
        }
        $UrlDestino = URLADM . 'listar-troca/listar-troca';
        header("Location: $UrlDestino");
    }

}
