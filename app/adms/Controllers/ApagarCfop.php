<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarCfop
{

    private $DadosId;

    public function apagarCfop($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarCfop = new \App\adms\Models\AdmsApagarCfop();
            $apagarCfop->apagarCfop($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um CFOP!</div>";
        }
        $UrlDestino = URLADM . 'cfop/listar';
        header("Location: $UrlDestino");
    }
}
