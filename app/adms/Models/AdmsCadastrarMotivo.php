<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarMotivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarMotivo {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadMotivo(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirMotivo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirMotivo() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadBandeira = new \App\adms\Models\helper\AdmsCreate;
        $cadBandeira->exeCreate("adms_motivo_estorno", $this->Dados);

        if ($cadBandeira->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Motivo de estorno cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Motivo de estorno não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

}
