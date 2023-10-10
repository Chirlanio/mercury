<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddBank
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsAddBank {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function addBank(array $Dados) {

        $this->Dados = $Dados;
        var_dump($this->Dados);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->insertBank();
        } else {
            $this->Resultado = false;
        }
    }

    private function insertBank() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadBrand = new \App\adms\Models\helper\AdmsCreate;
        $cadBrand->exeCreate("adms_banks", $this->Dados);

        if ($cadBrand->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Banco</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O banco não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
