<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarBandeira {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadBandeira(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirBandeira();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirBandeira() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadBandeira = new \App\adms\Models\helper\AdmsCreate;
        $cadBandeira->exeCreate("adms_bandeiras", $this->Dados);

        if ($cadBandeira->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Bandeira cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A bandeira não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

}
