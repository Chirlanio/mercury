<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarBandeira
{

    private $DadosId;

    public function apagarBandeira($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $apagarBandeira = new \App\adms\Models\AdmsApagarBandeira();
            $apagarBandeira->apagarBandeira($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma Bandeira!</div>";
        }
        $UrlDestino = URLADM . 'bandeira/listar';
        header("Location: $UrlDestino");
    }
}
