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
class ApagarTransf
{

    private $DadosId;

    public function apagarTransf($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarTransf = new \App\adms\Models\AdmsApagarTransf();
           $apagarTransf->apagarTransf($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma Transferência!</div>";
        }
        $UrlDestino = URLADM . 'transferencia/listarTransf';
        header("Location: $UrlDestino");
    }

}
