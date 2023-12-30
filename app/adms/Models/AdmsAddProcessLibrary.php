<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddProcessLibrary
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsAddProcessLibrary {

    private $Resultado;
    private $Dados;
    private $File;

    function getResultado() {
        return $this->Resultado;
    }

    public function addProcess(array $Dados) {

        $this->Dados = $Dados;

        $this->File = $this->Dados['file_name_process'];
        unset($this->Dados['file_name_process']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->insertProcess();
        } else {
            $this->Resultado = false;
        }
    }

    private function insertProcess() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $addProcess = new \App\adms\Models\helper\AdmsCreate();
        $addProcess->exeCreate("adms_process_librarys", $this->Dados);

        if ($addProcess->getResultado()) {
            if (empty($this->File['name'][0])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Processo/Política</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $addProcess->getResultado();
                $this->valArquivo();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O processo/política não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        if (!isset($this->File['name'][0])) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum arquivo foi selecionado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
            return;
        }

        $uploadPath = 'assets/files/processLibrary/' . $this->Dados['id'] . '/';
        $arquivosParaUpload = [];

        foreach ($this->File['name'] as $key => $filename) {
            $arquivosParaUpload[] = [
                'tmp_name' => $this->File['tmp_name'][$key],
                'name' => $filename,
                'type' => $this->File['type'][$key]
            ];
        }

        if (count($arquivosParaUpload) > 1) {
            $uploadFile = new \App\adms\Models\helper\AdmsUploadMultFiles();
            $uploadFile->upload($uploadPath, $arquivosParaUpload);
        } else {
            $newName = new \App\adms\Models\helper\AdmsSlug();
            $this->File['name'][0] = $newName->nomeSlug($this->File['name'][0]);

            $uploadFile = new \App\adms\Models\helper\AdmsUpload();
            $uploadFile->upload($arquivosParaUpload[0], $uploadPath, $this->File['name'][0]);
        }

        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Processo/Política:</strong> Cadastrada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->insertFiles();
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Processo/Política cadastrada. Erro ao realizar o upload do(s) arquivo(s)!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function insertFiles() {
        $countFiles = count($this->File['name']);

        $insertData = [];

        $slugName = new \App\adms\Models\helper\AdmsSlug();

        // Prepara os dados para inserção
        for ($i = 0; $i < $countFiles; $i++) {
            $insertData[] = [
                'adms_process_library_id' => $this->Dados['id'],
                'exibition_name' => $this->File['name'][$i],
                'file_name_slug' => $slugName->nomeSlug($this->File['name'][$i]),
                'status_id' => 1,
                'created' => date("Y-m-d H:i:s")
            ];
        }
        var_dump($insertData);

        // Insere os dados no banco de dados
        $installment = new \App\adms\Models\helper\AdmsCreate();

        foreach ($insertData as $data) {
            $installment->exeCreate('adms_process_library_files', $data);
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id cat_id, name_category category FROM adms_cats_process_librarys ORDER BY name_category ASC");
        $registro['cats'] = $listar->getResultado();

        $listar->fullRead("SELECT id a_id, name area_name FROM adms_areas ORDER BY name ASC");
        $registro['area'] = $listar->getResultado();

        $listar->fullRead("SELECT id sec_id, sector_name FROM adms_sectors ORDER BY sector_name ASC");
        $registro['sector'] = $listar->getResultado();

        $listar->fullRead("SELECT id m_id, name manager FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC ", "status_id=1");
        $registro['manager'] = $listar->getResultado();

        $listar->fullRead("SELECT f.id f_id, f.nome manager_sector FROM tb_funcionarios f LEFT JOIN tb_cargos c ON c.id = f.cargo_id LEFT JOIN adms_niv_cargos nv ON nv.id = c.adms_niv_cargo_id WHERE c.adms_niv_cargo_id =:adms_niv_cargo_id AND f.status_id =:status_id ORDER BY f.nome", "adms_niv_cargo_id=1&status_id=1");
        $registro['manager_sector'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit'], 'cats' => $registro['cats'], 'area' => $registro['area'], 'sector' => $registro['sector'], 'manager' => $registro['manager'], 'manager_sector' => $registro['manager_sector']];

        return $this->Resultado;
    }
}
