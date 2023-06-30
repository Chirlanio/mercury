<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarCiclo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarCiclo {

    private $DadosId;

    public function apagarCiclo($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $apagarCiclo = new \App\adms\Models\AdmsApagarCiclo();
            $apagarCiclo->apagarCiclo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Selecione um registro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'ciclos/listar';
        header("Location: $UrlDestino");
    }

}
