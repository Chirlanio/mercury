<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarRemanejo
{

    private $DadosId;

    public function apagarRemanejo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarRemanejo = new \App\adms\Models\AdmsApagarRemanejo();
            $apagarRemanejo->apagarRemanejo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um Remanejo!</div>";
        }
        $UrlDestino = URLADM . 'remanejo/listar';
        header("Location: $UrlDestino");
    }
}
