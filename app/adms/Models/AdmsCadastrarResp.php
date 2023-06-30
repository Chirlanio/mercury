<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarResp {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadResp(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirResp();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirResp() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadResp = new \App\adms\Models\helper\AdmsCreate;
        $cadResp->exeCreate("adms_resp_autorizacao", $this->Dados);
        if ($cadResp->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastrado não foi realizado com sucesso!</div>";
            $this->Resultado = false;
        }
    }

}
