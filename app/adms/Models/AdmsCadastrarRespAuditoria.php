<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarRespAuditoria {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadRespAuditoria(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirRespAuditoria();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirRespAuditoria() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadBairro = new \App\adms\Models\helper\AdmsCreate;
        $cadBairro->exeCreate("adms_responsavel_auditoria", $this->Dados);

        if ($cadBairro->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não realizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
