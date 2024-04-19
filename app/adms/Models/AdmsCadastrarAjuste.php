<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
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
        
        $this->Dados['referencia'] = strtoupper($this->Dados['referencia']);
        $this->Dados['referencia_2'] = strtoupper($this->Dados['referencia_2']);
        $this->Dados['referencia_3'] = strtoupper($this->Dados['referencia_3']);
        $this->Dados['referencia_4'] = strtoupper($this->Dados['referencia_4']);

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
        if ($cadAjuste->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Solicitação enviada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro: </strong>Solicitação não cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id t_id, nome tamanho FROM tb_tam ORDER BY nome ASC");
        $registro['tams'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT id_loja, id lj_id, nome loja FROM tb_lojas WHERE id =:id ORDER BY nome ASC", "id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id_loja, id lj_id, nome loja FROM tb_lojas ORDER BY nome ASC");
        }
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_aj ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] >= STOREPERMITION) {
            $listar->fullRead("SELECT id id_consul, nome consul FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id id_consul, nome consul FROM tb_funcionarios ORDER BY nome ASC");
        }
        $registro['func_id'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'tams' => $registro['tams'], 'func_id' => $registro['func_id']];

        return $this->Resultado;
    }

}
