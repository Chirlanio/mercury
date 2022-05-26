<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarSitBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarSitBalanco {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarSit($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarSit = new \App\adms\Models\helper\AdmsDelete();
        $apagarSit->exeDelete("adms_status_balancos", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarSit->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Registro</strong> apagado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
