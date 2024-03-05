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
        $cadAjuste->exeCreate("adms_balancos", $this->Dados);
        if ($cadAjuste->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não realizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
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
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_status_balancos ORDER BY id ASC");
        $registro['sit'] = $listar->getResult();

        $listar->fullRead("SELECT id c_id, nome ciclo, ano FROM adms_ciclos WHERE status_id !=:status_id ORDER BY id ASC", "status_id=4");
        $registro['ciclo'] = $listar->getResult();

        $listar->fullRead("SELECT id resp_auditor_id, nome resp FROM adms_responsavel_auditoria ORDER BY id ASC");
        $registro['resp'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] >= 5) {
            $listar->fullRead("SELECT id resp_loja_id, nome loja_resp FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id resp_loja_id, nome loja_resp FROM tb_funcionarios ORDER BY nome ASC");
        }
        $registro['func_id'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'ciclo' => $registro['ciclo'], 'sit' => $registro['sit'], 'resp' => $registro['resp'], 'func_id' => $registro['func_id']];

        return $this->Resultado;
    }

}
