<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarTipo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarTipo {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadTipo(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirTipo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirTipo() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadBairro = new \App\adms\Models\helper\AdmsCreate;
        $cadBairro->exeCreate("adms_tps_artigos", $this->Dados);

        if ($cadBairro->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de artigo cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de artigo não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

}
