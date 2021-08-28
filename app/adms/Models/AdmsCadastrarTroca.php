<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarTroca {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadTroca(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirTroca();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirTroca() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadTroca = new \App\adms\Models\helper\AdmsCreate;
        $cadTroca->exeCreate("tb_cad_produtos", $this->Dados);
        var_dump($cadTroca);
        if ($cadTroca->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] > 2) {
            $listar->fullRead("SELECT id id_loja, nome loja
                    FROM tb_lojas
                    WHERE id =:id
                    ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        }
        $registro['loja_id'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] >= 5) {
            $listar->fullRead("SELECT id id_consul, nome consul FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id id_consul, nome consul FROM tb_funcionarios ORDER BY nome ASC");
        }
        $registro['func_id'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id motivo_id, nome motivo FROM adms_motivos ORDER BY nome ASC");
        $registro['motivo_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'func_id' => $registro['func_id'], 'motivo_id' => $registro['motivo_id']];

        return $this->Resultado;
    }

}
