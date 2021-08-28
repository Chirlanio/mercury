<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarRota {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadRota(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirRota();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirRota() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadBairro = new \App\adms\Models\helper\AdmsCreate;
        $cadBairro->exeCreate("tb_rotas", $this->Dados);

        if ($cadBairro->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Rota cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O rota não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id c_id, nome cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor'] = $listar->getResultado();

        $this->Resultado = ['cor' => $registro['cor']];

        return $this->Resultado;
    }

}
