<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarTipoPagamento {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verTipo($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verBairro = new \App\adms\Models\helper\AdmsRead();
        $verBairro->fullRead("SELECT b.id, b.nome 
                FROM tb_forma_pag b
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBairro->getResultado();
        return $this->Resultado;
    }

    public function altTipo(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTipoPagamento();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTipoPagamento() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTipo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltTipo->exeUpdate("tb_forma_pag", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTipo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de pagamento atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de pagamento não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
