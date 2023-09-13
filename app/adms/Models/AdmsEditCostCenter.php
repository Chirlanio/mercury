<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditCostCenter {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function costCenter($DadosId) {

        $this->DadosId = (int) $DadosId;

        $viewCostCenter = new \App\adms\Models\helper\AdmsRead();
        $viewCostCenter->fullRead("SELECT cc.id c_id, cc.cost_center_id, cc.name costCenter, cc.manager_id, cc.status_id, cc.created, cc.modified
                FROM adms_cost_centers cc
                LEFT JOIN tb_funcionarios f ON f.id=cc.manager_id
                LEFT JOIN adms_sits s ON s.id=cc.status_id
                WHERE cc.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewCostCenter->getResultado();
        return $this->Resultado;
    }

    public function altCostCenter(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCostCenter();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCostCenter() {
        
        $this->Dados['cost_center_id'] = str_replace('.', '', $this->Dados['cost_center_id']);
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCostCenter = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCostCenter->exeUpdate("adms_cost_centers", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCostCenter->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Centro de custo</strong>  atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Centro de custo não atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id f_id, nome gerencia FROM tb_funcionarios WHERE cargo_id =:cargo_id AND status_id =:status_id ORDER BY id ASC", "cargo_id=2&status_id=1");
        $registro['resp'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $listar->getResultado();

        $this->Resultado = ['resp' => $registro['resp'], 'sits' => $registro['sits']];

        return $this->Resultado;
    }

}
