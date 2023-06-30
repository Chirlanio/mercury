<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarCat
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarCat
{

    private $DadosId;

    public function apagarCat($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $apagarCat = new \App\adms\Models\AdmsApagarCat();
            $apagarCat->apagarCat($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um tipo!</div>";
        }
        $UrlDestino = URLADM . 'categoria-artigo/listar';
        header("Location: $UrlDestino");
    }
}
