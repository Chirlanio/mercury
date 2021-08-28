<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarCor
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarCor
{

    private $DadosId;

    public function apagarCor($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarCor = new \App\adms\Models\AdmsApagarCor();
           $apagarCor->apagarCor($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma cor!</div>";
        }
        $UrlDestino = URLADM . 'cor/listar';
        header("Location: $UrlDestino");
    }

}
