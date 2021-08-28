<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarAjuste
{

    private $DadosId;

    public function apagarAjuste($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarAjuste = new \App\adms\Models\AdmsApagarAjuste();
           $apagarAjuste->apagarAjuste($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma ajuste de estoque!</div>";
        }
        $UrlDestino = URLADM . 'ajuste/listar-ajuste';
        header("Location: $UrlDestino");
    }

}
