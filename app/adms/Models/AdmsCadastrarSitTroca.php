<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarSitTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarSitTroca {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadSit(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirSit();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirSit() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadSit = new \App\adms\Models\helper\AdmsCreate;
        $cadSit->exeCreate("tb_status_troca", $this->Dados);
        if ($cadSit->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_cors" para utilizar como chave estrangeira
     */
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_cor, nome nome_cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor'] = $listar->getResultado();

        $this->Resultado = ['cor' => $registro['cor']];

        return $this->Resultado;
    }

}
