<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarFunc {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadFunc(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirFunc();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirFunc() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadDash = new \App\adms\Models\helper\AdmsCreate;
        $cadDash->exeCreate("tb_funcionarios", $this->Dados);
        if ($cadDash->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Funcionario cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Funcionario não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id cargo_id, nome cargo FROM tb_cargos ORDER BY nome ASC");
        $registro['cargo_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'cargo_id' => $registro['cargo_id']];

        return $this->Resultado;
    }

}
