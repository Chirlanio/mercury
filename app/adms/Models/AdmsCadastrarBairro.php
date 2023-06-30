<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarBairro {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadBairro(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirBairro();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirBairro() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadBairro = new \App\adms\Models\helper\AdmsCreate;
        $cadBairro->exeCreate("tb_bairros", $this->Dados);

        if ($cadBairro->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Bairro cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O bairro não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id r_id, nome rota FROM tb_rotas ORDER BY id ASC");
        $registro['rota_id'] = $listar->getResultado();

        $this->Resultado = ['rota_id' => $registro['rota_id']];

        return $this->Resultado;
    }

}
