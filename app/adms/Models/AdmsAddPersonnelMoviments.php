<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddPersonnelMoviments
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsAddPersonnelMoviments {

    private $Resultado;
    private $Dados;
    private $treatData;
    private $Filename;

    function getResultado() {
        return $this->Resultado;
    }

    public function addMoviment(array $Dados) {

        $this->Dados = $Dados;
        $this->Filename = !empty($this->Dados['file_name']) ? $this->Dados['file_name'] : null;
        if (isset($this->Dados['observation'])) {
            unset($this->Dados['observation']);
        }
        if (isset($this->Dados['file_name'])) {
            unset($this->Dados['file_name']);
        }

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->treatData($this->Dados);
        } else {
            $this->Resultado = false;
        }
    }

    private function treatData(array $Dados) {
        $this->treatData = $Dados;

        $this->treatData['adms_area_id'] = (isset($this->Dados['request_area_id']) and !empty($this->Dados['request_area_id'])) ? $this->Dados['request_area_id'] : 0;
        $this->treatData['fouls'] = (isset($this->Dados['totalFouls']) and !empty($this->Dados['totalFouls'])) ? $this->Dados['totalFouls'] : null;
        $this->treatData['days_off'] = (isset($this->Dados['totalDaysOff']) and !empty($this->Dados['totalDaysOff'])) ? $this->Dados['totalDaysOff'] : null;
        $this->treatData['folds'] = (isset($this->Dados['totalFolds']) and !empty($this->Dados['totalFolds'])) ? date("H:i:s", strtotime($this->Dados['totalFolds'])) : null;
        $this->treatData['fixed_fund'] = (isset($this->Dados['totalFund']) and !empty($this->Dados['totalFund'])) ? str_replace(",", ".", $this->Dados['totalFund']) : null;

        if (empty($this->treatData['fouls'])) {
            unset($this->treatData['fouls']);
        }
        if (empty($this->treatData['days_off'])) {
            unset($this->treatData['days_off']);
        }
        if (empty($this->treatData['folds'])) {
            unset($this->treatData['folds']);
        }
        if (empty($this->treatData['fixed_fund'])) {
            unset($this->treatData['fixed_fund']);
        }
        if (isset($this->treatData['totalFouls'])) {
            unset($this->treatData['totalFouls']);
        }
        if (isset($this->treatData['totalDaysOff'])) {
            unset($this->treatData['totalDaysOff']);
        }
        if (isset($this->treatData['totalFolds'])) {
            unset($this->treatData['totalFolds']);
        }
        if (isset($this->treatData['totalFund'])) {
            unset($this->treatData['totalFund']);
        }

        $this->insertMoviment();
    }

    private function insertMoviment() {

        $this->treatData['adms_sits_personnel_mov_id'] = 1;
        $this->treatData['created'] = date("Y-m-d H:i:s");

        $addProcess = new \App\adms\Models\helper\AdmsCreate();
        $addProcess->exeCreate("adms_personnel_moviments", $this->treatData);

        if ($addProcess->getResult()) {
            $this->Dados['id'] = $addProcess->getResult();
            $this->valArquivo();
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Movimentação</strong> cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A Movimentação não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        if (!isset($this->Filename['name'][0])) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum arquivo foi selecionado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
            return;
        }

        $uploadPath = 'assets/files/mp/' . $this->Dados['id'] . '/';
        $arquivosParaUpload = [];

        foreach ($this->Filename['name'] as $key => $filename) {
            $arquivosParaUpload[] = [
                'tmp_name' => $this->Filename['tmp_name'][$key],
                'name' => $filename,
                'type' => $this->Filename['type'][$key],
                'error' => $this->Filename['error'][$key],
                'size' => $this->Filename['size'][$key]
            ];
        }

        if (count($arquivosParaUpload) > 1) {
            $uploadFile = new \App\adms\Models\helper\AdmsUploadMultFiles();
            $uploadFile->upload($uploadPath, $arquivosParaUpload);
        } else {
            $newName = new \App\adms\Models\helper\AdmsSlug();
            $this->Filename['name'][0] = $newName->nomeSlug($this->Filename['name'][0]);

            $uploadFile = new \App\adms\Models\helper\AdmsUpload();
            $uploadFile->upload($arquivosParaUpload[0], $uploadPath, $this->Filename['name'][0]);
        }

        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação cadastrada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação cadastrada. Erro ao realizar o upload do arquivo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id={$_SESSION['usuario_loja']}");
        } else {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        }
        $registro['store'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC");
        }
        $registro['employee'] = $listar->getResult();

        $listar->fullRead("SELECT id a_id, name area_name FROM adms_areas ORDER BY name ASC");
        $registro['area_id'] = $listar->getResult();

        $listar->fullRead("SELECT id m_id, name manager FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC ", "status_id=1");
        $registro['manager'] = $listar->getResult();

        $listar->fullRead("SELECT f.id f_id, f.nome manager_sector FROM tb_funcionarios f LEFT JOIN tb_cargos c ON c.id = f.cargo_id LEFT JOIN adms_niv_cargos nv ON nv.id = c.adms_niv_cargo_id WHERE c.adms_niv_cargo_id =:adms_niv_cargo_id AND f.status_id =:status_id ORDER BY f.nome", "adms_niv_cargo_id=1&status_id=1");
        $registro['manager_sector'] = $listar->getResult();

        $this->Resultado = ['store' => $registro['store'], 'employee' => $registro['employee'], 'area_id' => $registro['area_id'], 'manager' => $registro['manager'], 'manager_sector' => $registro['manager_sector']];

        return $this->Resultado;
    }
}
