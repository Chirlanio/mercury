<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

class EditProcessLibraryFiles {

    private $Dados;
    private $DadosId;

    public function editFiles($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editProcessLibraryFilePriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'process-library/list';
            header("Location: $UrlDestino");
        }
    }

    private function editProcessLibraryFilePriv() {
        if (!empty($this->Dados['EditFiles'])) {
            unset($this->Dados['EditFiles']);
            var_dump($this->Dados);

            $editProcess = new \App\adms\Models\AdmsEditFiles();
            $editProcess->altFiles($this->Dados);

            if ($editProcess->getResultado()) {
                $UrlDestino = URLADM . 'process-library/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editProcessLibraryViewPriv();
            }
        } else {
            $viewFiles = new \App\adms\Models\AdmsEditFiles();
            $this->Dados['form'] = $viewFiles->viewFiles($this->DadosId);
            $this->editProcessLibraryViewPriv();
        }
    }

    private function editProcessLibraryViewPriv() {
        if ($this->Dados['form']) {

            $listSelect = new \App\adms\Models\AdmsEditFiles();
            $this->Dados['select'] = $listSelect->listAdd();

            $botao = [
                'view_process' => ['menu_controller' => 'view-process-library', 'menu_metodo' => 'process-library'],
                'list_process' => ['menu_controller' => 'process-library', 'menu_metodo' => 'list']
            ];

            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/biblioteca/editProcessLibraryFiles", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum arquivo encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'process-library/list';
            header("Location: $UrlDestino");
        }
    }

    private function delFiles() {
        $this->Dados['id'] = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
        $this->Dados['delete'] = filter_input(INPUT_GET, 'file', FILTER_DEFAULT);
        
        $delFile = new \App\adms\Models\AdmsEditFiles();
        $delFile->delFileBd($this->Dados['id']);
        if ($delFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Arquivo</strong> deletado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        $delFilename = new \App\adms\Models\helper\AdmsApagarArq();
        $delFilename->apagarArq($this->Dados['delete'], 'assets/files/processLibrary/' . $this->Dados['id'] . '/');
    }
}
