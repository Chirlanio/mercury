<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsAddSupplier {

    private $Resultado;
    private $Dados;
    private string $DataSupplier;
    private array|object|string|null $DadosSupplier = [];

    function getResultado() {
        return $this->Resultado;
    }

    public function addSupplier(array $Dados) {

        $this->Dados = $Dados;

        $this->Dados['cnpj_cpf'] = str_replace('-', '', str_replace('/', '', str_replace('.', '', $this->Dados['cnpj_cpf'])));
        $this->Dados['contact'] = str_replace(' ', '', str_replace('(', '', str_replace(')', '', str_replace('-', '', $this->Dados['contact']))));

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->viewSupplier($this->Dados['cnpj_cpf']);
        } else {
            $this->Resultado = false;
        }
    }

    private function viewSupplier(string $DataSupplier) {
        $this->DataSupplier = $DataSupplier;

        $viewSupplier = new \App\adms\Models\helper\AdmsRead();
        $viewSupplier->fullRead("SELECT id sup_id, fantasy_name, cnpj_cpf FROM adms_suppliers WHERE cnpj_cpf =:cnpj", "cnpj={$this->DataSupplier}");
        $this->DadosSupplier = $viewSupplier->getResult();

        if ($viewSupplier->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Fornecedor já cadastrado. <strong>ID:</strong> {$this->DadosSupplier[0]['sup_id']}, <strong>Nome:</strong> {$this->DadosSupplier[0]['fantasy_name']}!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        } else {
            $this->insertSupplier();
        }
    }

    private function insertSupplier() {

        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadSupplier = new \App\adms\Models\helper\AdmsCreate;
        $cadSupplier->exeCreate("adms_suppliers", $this->Dados);

        if ($cadSupplier->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Fornecedor</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O fornecedor não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }
}
