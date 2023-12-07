<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditProcessLibrary
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditProcessLibrary {

    private $Dados;
    private $DadosId;

    public function processLibrary($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->Dados['id'] = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
        $this->Dados['delete'] = filter_input(INPUT_GET, 'file', FILTER_DEFAULT);

        if (!empty($this->Dados['delete'])) {
            $this->delFiles();
        }

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editProcessLibraryPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'process-library/list';
            header("Location: $UrlDestino");
        }
    }

    private function editProcessLibraryPriv() {
        if (!empty($this->Dados['EditProcess'])) {
            unset($this->Dados['EditProcess']);

            $editProcess = new \App\adms\Models\AdmsEditProcessLibrary();
            $editProcess->altProcess($this->Dados);

            if ($editProcess->getResultado()) {
                $UrlDestino = URLADM . 'process-library/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editProcessLibraryViewPriv();
            }
        } else {
            $viewProcess = new \App\adms\Models\AdmsEditProcessLibrary();
            $this->Dados['form'] = $viewProcess->processLibrary($this->DadosId);
            $this->editProcessLibraryViewPriv();
        }
    }

    private function editProcessLibraryViewPriv() {
        if ($this->Dados['form']) {

            $listSelect = new \App\adms\Models\AdmsEditProcessLibrary();
            $this->Dados['select'] = $listSelect->listAdd();

            $botao = ['view_process' => ['menu_controller' => 'view-process-library', 'menu_metodo' => 'process-library'],
                'list_process' => ['menu_controller' => 'process-library', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/biblioteca/editProcessLibrary", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Processo/Política não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'process-library/list';
            header("Location: $UrlDestino");
        }
    }

    private function delFiles() {
        $delFilename = new \App\adms\Models\helper\AdmsApagarArq();
        $delFilename->apagarArq($this->Dados['delete'], 'assets/files/processLibrary/' . $this->Dados['id'] . '/');
    }
}
