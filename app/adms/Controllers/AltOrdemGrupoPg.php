<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AltOrdemGrupoPg
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AltOrdemGrupoPg
{

    private $DadosId;

    public function altOrdemGrupoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altOrdemGrupoPg = new \App\adms\Models\AdmsAltOrdemGrupoPg();
            $altOrdemGrupoPg->altOrdemGrupoPg($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um grupo de página!</div>";
        }
        $UrlDestino = URLADM . 'grupo-pg/listar';
        header("Location: $UrlDestino");
    }
}
