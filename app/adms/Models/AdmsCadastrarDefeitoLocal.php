<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarDefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarDefeitoLocal {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadDefeitoLocal(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirDefeitoLocal();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirDefeitoLocal() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadDefLocal = new \App\adms\Models\helper\AdmsCreate;
        $cadDefLocal->exeCreate("adms_def_local_ordem_servico", $this->Dados);

        if ($cadDefLocal->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Local</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O Local não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("select id s_id, nome sit from adms_sits");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
