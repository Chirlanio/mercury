<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarMotivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarMotivo
{

    private $DadosId;

    public function apagarMotivo($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $apagarMotivo = new \App\adms\Models\AdmsApagarMotivo();
            $apagarMotivo->apagarMotivo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um Motivo de estorno!</div>";
        }
        $UrlDestino = URLADM . 'motivo-estorno/listar';
        header("Location: $UrlDestino");
    }
}
