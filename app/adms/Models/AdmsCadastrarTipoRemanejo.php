<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarTipoRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarTipoRemanejo {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadTipoRemanejo(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirTipoRemanejo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirTipoRemanejo() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadTipoRemanejo = new \App\adms\Models\helper\AdmsCreate;
        $cadTipoRemanejo->exeCreate("adms_tps_remanejos", $this->Dados);

        if ($cadTipoRemanejo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de Remanejo cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Tipo de Remanejo não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

}
