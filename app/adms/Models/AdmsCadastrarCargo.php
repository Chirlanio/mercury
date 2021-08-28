<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarCargo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarCargo {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadCargo(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirCargo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirCargo() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadCargo = new \App\adms\Models\helper\AdmsCreate;
        $cadCargo->exeCreate("tb_cargos", $this->Dados);
        if ($cadCargo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cargo cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cargo não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

}
