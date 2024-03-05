<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditProcessLibrary
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditProcessLibrary {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function processLibrary($DadosId) {
        $this->DadosId = (int) $DadosId;
        $_SESSION['id'] = $this->DadosId;
        $viewProcess = new \App\adms\Models\helper\AdmsRead();
        $viewProcess->fullRead("SELECT pl.id pl_id, title, adms_cats_process_id, version_number, adms_area_id, adms_manager_area_id, adms_sector_id, adms_manager_sector_id, date_validation_start, date_validation_end, adms_sit_id FROM adms_process_librarys pl WHERE pl.id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        $this->Resultado = $viewProcess->getResult();
        return $this->Resultado;
    }

    public function altProcess(array $Dados) {
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        unset($this->Dados['id'], $this->Dados['delete']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditProcessLibrary();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditProcessLibrary() {

        $this->Dados['id'] = $_SESSION['id'];
        unset($this->Dados['pl_id']);
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_process_librarys", $this->Dados, "WHERE id =:id", "id=" . $_SESSION['id']);
        if ($upAltOrder->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento</strong> atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A ordem de pagamento não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id a_id, name area FROM adms_areas ORDER BY name ASC");
        $registro['area'] = $listar->getResult();

        $listar->fullRead("SELECT id c_id, name_category FROM adms_cats_process_librarys WHERE adms_sits_id =:adms_sits_id ORDER BY name_category ASC", 'adms_sits_id=1');
        $registro['cats'] = $listar->getResult();

        $listar->fullRead("SELECT id m_id, name manager_area FROM adms_managers WHERE status_id =:status_id", "status_id=1");
        $registro['managerAreas'] = $listar->getResult();

        $listar->fullRead("SELECT id s_id, sector_name  FROM adms_sectors WHERE adms_sit_id =:adms_sit_id", "adms_sit_id=1");
        $registro['sectors'] = $listar->getResult();
        
        $listar->fullRead("SELECT f.id f_id, f.nome manager_sector FROM tb_funcionarios f LEFT JOIN tb_cargos c ON c.id = f.cargo_id LEFT JOIN adms_niv_cargos nv ON nv.id = c.adms_niv_cargo_id WHERE c.adms_niv_cargo_id =:adms_niv_cargo_id AND f.status_id =:status_id ORDER BY f.nome", "adms_niv_cargo_id=1&status_id=1");
        $registro['managerSectors'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $listar->getResult();

        $this->Resultado = ['area' => $registro['area'], 'cats' => $registro['cats'], 'managerAreas' => $registro['managerAreas'], 'sectors' => $registro['sectors'], 'managerSectors' => $registro['managerSectors'], 'sits' => $registro['sits']];

        return $this->Resultado;
    }
}
