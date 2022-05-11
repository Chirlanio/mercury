<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AltOrdemTipoPg
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AltOrdemTipoPg
{

    private $DadosId;

    public function altOrdemTipoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altOrdemTipoPg = new \App\adms\Models\AdmsAltOrdemTipoPg();
            $altOrdemTipoPg->altOrdemTipoPg($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um tipo de página!</div>";
        }
        $UrlDestino = URLADM . 'tipo-pg/listar';
        header("Location: $UrlDestino");
    }
}
