<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarAjuste {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadAjuste(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirAjuste();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirAjuste() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadAjuste = new \App\adms\Models\helper\AdmsCreate;
        $cadAjuste->exeCreate("tb_ajuste", $this->Dados);
        if ($cadAjuste->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi cadastrada!</div>";
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

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_aj ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tam, nome tam FROM tb_tam ORDER BY nome ASC");
        $registro['tam_id'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] >= 5) {
            $listar->fullRead("SELECT id id_consul, nome consul FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id id_consul, nome consul FROM tb_funcionarios ORDER BY nome ASC");
        }
        $registro['func_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'tam_id' => $registro['tam_id'], 'func_id' => $registro['func_id']];

        return $this->Resultado;
    }

}
