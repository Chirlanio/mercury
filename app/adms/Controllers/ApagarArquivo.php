<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarArquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarArquivo
{

    private $DadosId;

    public function apagarArquivo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarArq = new \App\adms\Models\AdmsApagarArquivo();
            $apagarArq->apagarArquivo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um arquivo!</div>";
        }
        $UrlDestino = URLADM . 'arquivo/listar';
        header("Location: $UrlDestino");
    }
}
