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
        $this->Dados['cost_center_id'] = str_replace('.', '', $this->Dados['cost_center_id']);

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

        if ($addCostCenter->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Centro de custo</strong>  cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O Centro de custo não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $listar->getResult();

        $listar->fullRead("SELECT id a_id, name name_area FROM adms_areas ORDER BY name ASC");
        $registro['areas'] = $listar->getResult();

        $listar->fullRead("SELECT id r_id, name responsavel FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['resp'] = $listar->getResult();

        $this->Resultado = ['resp' => $registro['resp'], 'sits' => $registro['sits'], 'areas' => $registro['areas']];

        return $this->Resultado;
    }
}
