<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarResp
{

    private $DadosId;

    public function apagarResp($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarResp = new \App\adms\Models\AdmsApagarResp();
            $apagarResp->apagarResp($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um responsável!</div>";
        }
        $UrlDestino = URLADM . 'autorizacao-resp/listar';
        header("Location: $UrlDestino");
    }
}
