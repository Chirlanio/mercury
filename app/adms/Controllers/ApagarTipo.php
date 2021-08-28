<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarTipo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarTipo {

    private $DadosId;

    public function apagarTipo($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $apagarTipo = new \App\adms\Models\AdmsApagarTipo();
            $apagarTipo->apagarTipo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um tipo!</div>";
        }
        $UrlDestino = URLADM . 'tipo-artigo/listar';
        header("Location: $UrlDestino");
    }

}
