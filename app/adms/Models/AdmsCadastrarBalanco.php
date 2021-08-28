<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarBalanco {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadBalanco(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirBalanco();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirBalanco() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadAjuste = new \App\adms\Models\helper\AdmsCreate;
        $cadAjuste->exeCreate("adms_aud_balancos", $this->Dados);
        if ($cadAjuste->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Balanço cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O balanço não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] > 3) {
            $listar->fullRead("SELECT id_loja, id lj_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY nome ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id_loja, id lj_id, nome loja FROM tb_lojas ORDER BY nome ASC");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id resp_auditor_id, nome resp FROM adms_aud_resp ORDER BY id ASC");
        $registro['resp'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] >= 5) {
            $listar->fullRead("SELECT id resp_loja_id, nome loja_resp FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id resp_loja_id, nome loja_resp FROM tb_funcionarios ORDER BY nome ASC");
        }
        $registro['func_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'resp' => $registro['resp'], 'func_id' => $registro['func_id']];

        return $this->Resultado;
    }

}
