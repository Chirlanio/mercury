<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarSitUser
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarSitUser {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadSitUser(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirSitUser();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirSitUser() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadSitUser = new \App\adms\Models\helper\AdmsCreate;
        $cadSitUser->exeCreate("adms_sits_usuarios", $this->Dados);
        if ($cadSitUser->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação de usuário cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de usuário não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_cors" para utilizar como chave estrangeira
     */
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_cor, nome nome_cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor'] = $listar->getResult();

        $this->Resultado = ['cor' => $registro['cor']];

        return $this->Resultado;
    }

}
