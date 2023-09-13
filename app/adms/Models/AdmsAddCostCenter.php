<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsAddCostCenter {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function addCostCenter(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->addCenterCost();
        } else {
            $this->Resultado = false;
        }
    }

    private function addCenterCost() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $addCostCenter = new \App\adms\Models\helper\AdmsCreate;
        $addCostCenter->exeCreate("adms_cost_centers", $this->Dados);

        if ($addCostCenter->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Centro de custo</strong>  cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O Centro de custo não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id r_id, nome responsavel FROM tb_funcionarios WHERE cargo_id =:cargo_id AND status_id =:status_id ORDER BY id ASC", "cargo_id=2&status_id=1");
        $registro['resp'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $listar->getResultado();

        $this->Resultado = ['resp' => $registro['resp'], 'sits' => $registro['sits']];

        return $this->Resultado;
    }

}
