<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDelProcessLibrary
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDelProcessLibrary {

    private $DadosId;
    private $Resultado;
    private $DadosArq;
    private $DadosFile;

    function getResultado() {
        return $this->Resultado;
    }

    public function delProcessLibrary($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->viewProcess();
        $this->delProcessLibraryFile($this->DadosId);

        if ($this->DadosArq) {

            $delProcess = new \App\adms\Models\helper\AdmsDelete();
            $delProcess->exeDelete("adms_process_librarys", "WHERE id =:id", "id={$this->DadosId}");
            if ($delProcess->getResult()) {
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O Arquivo não foi apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Cadastro e o Arquivos não foram apagados!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function delProcessLibraryFile($DadosId) {
        $this->DadosId = (int) $DadosId;
        $this->viewProcessFile($this->DadosId);

        if (!empty($this->DadosFile)) {
            foreach ($this->DadosFile as $filename) {
                $delProcessFiles = new \App\adms\Models\helper\AdmsDelete();
                $delProcessFiles->exeDelete("adms_process_library_files", "WHERE id =:id", "id={$filename['id']}");

                if ($delProcessFiles->getResult()) {
                    $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                    $apagarImg->apagarImg('assets/files/processLibrary/' . $this->DadosId . '/' . $filename['file_name_slug'], 'assets/files/processLibrary/' . $filename['adms_process_library_id']);
                    $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Política ou Processo</strong> e arquivos apagados com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $this->Resultado = true;
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Política ou Processo</strong> e arquivos apagados com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $this->Resultado = true;
                }
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Cadastro e o Arquivos não foram apagados!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function viewProcess() {
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT * FROM adms_process_librarys WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArq = $viewOrder->getResult();
    }

    private function viewProcessFile($FileId = null) {
        $this->DadosId = (int) $FileId;
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT id, adms_process_library_id, file_name_slug FROM adms_process_library_files WHERE adms_process_library_id =:adms_process_library_id", "adms_process_library_id=" . $this->DadosId);
        $this->DadosFile = $viewOrder->getResult();
    }
}
