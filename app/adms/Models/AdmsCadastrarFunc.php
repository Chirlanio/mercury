<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
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
    private $Cupom;
    private $Dados;
    private string $DataUser;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadFunc(array $Dados) {

        $this->Dados = $Dados;
        $this->Dados['nome'] = ucwords($this->Dados['nome'], " \t\r\n\f\v'");
        $this->Dados['usuario'] = ucwords($this->Dados['nome'], " \t\r\n\f\v'");

        $this->Cupom = $this->Dados['cupom_site'];
        unset($this->Dados['cupom_site']);

        $this->Dados['cpf'] = str_replace('.', '', str_replace('-', '', $this->Dados['cpf']));

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->viewUniqueCPF($this->Dados['cpf']);
        } else {
            $this->Resultado = false;
        }
    }

    private function viewUniqueCPF(string $DataUser) {
        $this->DataUser = $DataUser;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, nome FROM tb_funcionarios WHERE cpf =:cpf", "cpf={$this->DataUser}");

        if ($viewUser->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário já cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        } else {
            $this->inserirFunc();
        }
    }

    private function inserirFunc() {

        $this->Dados['cupom_site'] = strtoupper($this->Cupom);
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadFunc = new \App\adms\Models\helper\AdmsCreate;
        $cadFunc->exeCreate("tb_funcionarios", $this->Dados);
        if ($cadFunc->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Funcionário</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Funcionário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResult();

        $listar->fullRead("SELECT id cargo_id, nome cargo FROM tb_cargos ORDER BY nome ASC");
        $registro['cargo_id'] = $listar->getResult();

        $listar->fullRead("SELECT id area_id, name name_area FROM adms_areas WHERE status_id =:sits", "sits=1");
        $registro['areas'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'cargo_id' => $registro['cargo_id'], 'areas' => $registro['areas']];

        return $this->Resultado;
    }
}
