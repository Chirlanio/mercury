<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarPed
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarPed {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadPed(array $Dados) {
        
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirPed();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirPed() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadPed = new \App\adms\Models\helper\AdmsCreate;
        $cadPed->exeCreate("tb_prateleira_infinita", $this->Dados);
        if ($cadPed->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Pedido cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O pedido não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] != 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:loja_id ORDER BY id ASC", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] != 5) {
            $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_prat ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_prat ORDER BY id ASC");
        }
        $registro['sit'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] != 5) {
            $listar->fullRead("SELECT id id_func, nome func FROM tb_funcionarios ORDER BY nome ASC");
        } else {
            $listar->fullRead("SELECT id id_func, nome func FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['func'] = $listar->getResultado();

        $listar->fullRead("SELECT id tam_id, nome tam FROM tb_tam ORDER BY nome ASC");
        $registro['tam'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'func' => $registro['func'], 'tam' => $registro['tam']];

        return $this->Resultado;
    }

}
