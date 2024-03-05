<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

class AdmsEditFiles
{
    private $Resultado;
    private $Dados;
    private $DadosId;
    private $File;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function viewFiles($DadosId)
    {
        $this->DadosId = (int)$DadosId;
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT op.* FROM adms_process_library_files op WHERE op.adms_process_library_id =:adms_process_library_id", "adms_process_library_id={$this->DadosId}");
        $this->Resultado = $viewOrder->getResult();
        return $this->Resultado;
    }

    public function altFiles(array $Dados)
    {
        $this->Dados = $Dados;
        $this->File = $_FILES['new_files'];
        //var_dump($this->File);

        unset($this->Dados['id'], $this->Dados['delete']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            if (!empty($this->File['name'][0])) {
                $this->valArquivo();
            } else {
                $this->updateEditOrderPayment();
            }
        } else {
            $this->Resultado = false;
        }
    }

    private function valArquivo()
    {
        if (!isset($this->File['name'][0])) {
            $this->updateFiles();
        }

        $uploadPath = 'assets/files/processLibrary/' . $_SESSION['id'] . '/';
        $arquivosParaUpload = [];

        foreach ($this->File['name'] as $key => $filename) {
            $arquivosParaUpload[] = [
                'tmp_name' => $this->File['tmp_name'][$key],
                'name' => $filename,
                'type' => $this->File['type'][$key]
            ];
        }

        $uploadFile = new \App\adms\Models\helper\AdmsUploadMultFiles();
        $uploadFile->upload($uploadPath, $arquivosParaUpload);

        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function updateFiles()
    {
        // Seu código para atualizar os arquivos no banco de dados
    }

    public function delFileBd($fileId)
    {
        $fileId['id'] = (int)$fileId;

        $delFile = new \App\adms\Models\helper\AdmsDelete();
        $delFile->exeDelete("adms_process_library_files", "WHERE id =:id", "id={$fileId['id']}");
        $this->Resultado = $delFile->getResult();
        return $this->Resultado;
    }

    public function listAdd()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id pl_id, title processLibrary FROM adms_process_librarys ORDER BY title ASC");
        $registro['process'] = $listar->getResult();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $listar->getResult();

        $this->Resultado = ['process' => $registro['process'], 'sits' => $registro['sits']];

        return $this->Resultado;
    }
}
