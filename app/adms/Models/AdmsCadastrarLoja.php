<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarLoja
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarLoja {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadLoja(array $Dados) {
        
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);
        
        if ($valCampoVazio->getResultado()) {
            $this->inserirLoja();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirLoja() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadLoja = new \App\adms\Models\helper\AdmsCreate;
        $cadLoja->exeCreate("tb_lojas", $this->Dados);
        //var_dump($cadLoja->getResultado());
        if ($cadLoja->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Loja cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A loja não foi cadastrada, CNPJ duplicado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_loja ORDER BY id ASC");
        $registro['status_id'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id rede_id, nome rede FROM tb_redes ORDER BY id ASC");
        $registro['rede_id'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id func_id, nome func FROM tb_funcionarios WHERE cargo_id =:cargo_id AND status_id =:status_id ORDER BY nome ASC", "cargo_id=2&status_id=1");
        $registro['func_id'] = $listar->getResultado();

        $this->Resultado = ['status_id' => $registro['status_id'], 'rede_id' => $registro['rede_id'], 'func_id' => $registro['func_id']];

        return $this->Resultado;
    }

}
