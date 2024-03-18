<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarTransf {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadTransf(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirTransf();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirTransf() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadDash = new \App\adms\Models\helper\AdmsCreate;
        $cadDash->exeCreate("tb_transferencias", $this->Dados);
        if ($cadDash->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Transferência cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A transferência não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id t_id, nome tipo FROM tb_tipo_transf ORDER BY id ASC");
        $registro['tipo_transf'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] == STOREPERMITION) {
            $listar->fullRead("SELECT id ld_id, nome loja_dest FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id ld_id, nome loja_dest FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_destino'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] == STOREPERMITION) {
            $listar->fullRead("SELECT id lo_id, nome loja_orig FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id lo_id, nome loja_orig FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_origem'] = $listar->getResult();

        $this->Resultado = ['loja_origem' => $registro['loja_origem'], 'loja_destino' => $registro['loja_destino'], 'tipo_transf' => $registro['tipo_transf']];

        return $this->Resultado;
    }

}
