<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditPersonnelMoviments
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditPersonnelMoviments {

    private $Dados;
    private $DadosId;

    public function editMoviment($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->Dados['id'] = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
        $this->Dados['delete'] = filter_input(INPUT_GET, 'file', FILTER_DEFAULT);

        if (!empty($this->Dados['delete'])) {
            $this->delFiles();
        }

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editPersonnelMovimentPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'personnel-moviments/list';
            header("Location: $UrlDestino");
        }
    }

    private function editPersonnelMovimentPriv() {
        if (!empty($this->Dados['EditMoviment'])) {
            unset($this->Dados['EditMoviment']);
            $this->Dados['file_name'] = (isset($_FILES['file_name']) ? $_FILES['file_name'] : null);
            
            $editMoviment = new \App\adms\Models\AdmsEditPersonnelMoviments();
            $editMoviment->altOrder($this->Dados);

            if ($editMoviment->getResultado()) {
                $UrlDestino = URLADM . 'personnel-moviments/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editPersonnelMovimentViewPriv();
            }
        } else {
            $viewMoviment = new \App\adms\Models\AdmsEditPersonnelMoviments();
            $this->Dados['form'] = $viewMoviment->viewMoviment($this->DadosId);
            $this->editPersonnelMovimentViewPriv();
        }
    }

    private function editPersonnelMovimentViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditPersonnelMoviments();
            $this->Dados['select'] = $listarSelect->listAdd();

            $botao = ['view_moviment' => ['menu_controller' => 'view-personnel-moviments', 'menu_metodo' => 'view-moviment'],
                'list_moviment' => ['menu_controller' => 'personnel-moviments', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/personnelMoviment/editPersonnelMoviment", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Só é permitida a atualização nas Situações \"Pendente ou Em andamento\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'personnel-moviments/list';
            header("Location: $UrlDestino");
        }
    }

    private function delFiles() {
        $delFilename = new \App\adms\Models\helper\AdmsApagarArq();
        $delFilename->apagarArq($this->Dados['delete'], 'assets/files/mp/' . $this->Dados['id'] . '/');
    }
}
