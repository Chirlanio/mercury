<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarEstorno
{

    private $DadosId;

    public function apagarEstorno($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarEstorno = new \App\adms\Models\AdmsApagarEstorno();
            $apagarEstorno->apagarEstorno($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma solicitação!</div>";
        }
        $UrlDestino = URLADM . 'estorno/listar';
        header("Location: $UrlDestino");
    }
}
