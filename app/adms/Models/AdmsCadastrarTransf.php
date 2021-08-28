<?php

namespace App\adms\Models;

if (!defined('URL')) {
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
        if ($cadDash->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Transferência cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A transferência não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] >= 3) {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja_orig FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_origem_id'] = $listar->getResultado();

        if ($_SESSION['ordem_nivac'] >= 3) {
            $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas WHERE id !=:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja_dest FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_destino_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tipo, nome tipo FROM tb_tipo_transf ORDER BY id ASC");
        $registro['tipo_transf_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sit, nome sit FROM tb_status_transf ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['loja_origem_id' => $registro['loja_origem_id'], 'loja_destino_id' => $registro['loja_destino_id'], 'tipo_transf_id' => $registro['tipo_transf_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
