<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarRota
{

    private $DadosId;

    public function apagarRota($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $apagarRota = new \App\adms\Models\AdmsApagarRota();
            $apagarRota->apagarRota($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma rota!</div>";
        }
        $UrlDestino = URLADM . 'rota/listar';
        header("Location: $UrlDestino");
    }
}
