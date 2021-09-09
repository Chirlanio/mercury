<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarCfop {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadCfop(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirCfop();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirCfop() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadCfop = new \App\adms\Models\helper\AdmsCreate;
        $cadCfop->exeCreate("adms_cfops", $this->Dados);
        if ($cadCfop->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>CFOP cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O CFOP não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

}
