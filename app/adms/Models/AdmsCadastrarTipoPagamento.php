<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarTipoPagamento {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadTipo(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirTipo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirTipo() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadTipo = new \App\adms\Models\helper\AdmsCreate;
        $cadTipo->exeCreate("tb_forma_pag", $this->Dados);

        if ($cadTipo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de Pagamento cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Tipo de Pagamento não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

}
