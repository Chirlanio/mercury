<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarDefeitos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarDefeitos {

    private $DadosId;

    public function apagarDefeitos($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarDefeitos = new \App\adms\Models\AdmsApagarDefeitos();
            $apagarDefeitos->apagarDefeitos($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar um cadastro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'defeitos/listar';
        header("Location: $UrlDestino");
    }

}
