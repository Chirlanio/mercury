<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarDashboard
{

    private $DadosId;

    public function apagarDashboard($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarDash = new \App\adms\Models\AdmsApagarDashboard();
           $apagarDash->apagarDashboard($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma Dashboard!</div>";
        }
        $UrlDestino = URLADM . 'dashboard/listar';
        header("Location: $UrlDestino");
    }

}
