<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarDetalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarDetalhes {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarDetalhes($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarDetalhes = new \App\adms\Models\helper\AdmsDelete();
        $apagarDetalhes->exeDelete("adms_detalhes_ordem_servico", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarDetalhes->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Registro</strong> apagado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O registro não foi apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
