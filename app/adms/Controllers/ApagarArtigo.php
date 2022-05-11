<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarArtigo
 *
 * @copyright (c) year, Chirlanio Silvas - Grupo Meia Sola
 */
class ApagarArtigo
{

    private $DadosId;

    public function apagarArtigo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarArtigo = new \App\adms\Models\AdmsApagarArtigo();
            $apagarArtigo->apagarArtigo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um artigo!</div>";
        }
        $UrlDestino = URLADM . 'artigo/listar';
        header("Location: $UrlDestino");
    }
}
