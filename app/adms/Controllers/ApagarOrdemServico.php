<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarOrdemServico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarOrdemServico
{

    private $DadosId;

    public function apagarOrdemServico($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarOrdemServico = new \App\adms\Models\AdmsApagarOrdemServico();
            $apagarOrdemServico->apagarOrdemServico($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma ordem de serviço!</div>";
        }
        $UrlDestino = URLADM . 'ordem-servico/listar';
        header("Location: $UrlDestino");
    }
}
