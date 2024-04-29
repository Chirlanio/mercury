<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditVacancyOpening
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditVacancyOpening {

    private $Dados;
    private $DadosId;

    public function editVacancy($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editVacancyOpeningPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'vacancy-opening/list';
            header("Location: $UrlDestino");
        }
    }

    private function editVacancyOpeningPriv() {
        if (!empty($this->Dados['EditVacancy'])) {
            unset($this->Dados['EditVacancy']);

            $editVacancy = new \App\adms\Models\AdmsEditVacancyOpening();
            $editVacancy->altVacancy($this->Dados);

            if ($editVacancy->getResultado()) {
                $UrlDestino = URLADM . 'vacancy-opening/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editVacancyOpeningViewPriv();
            }
        } else {
            $viewVacancy = new \App\adms\Models\AdmsEditVacancyOpening();
            $this->Dados['form'] = $viewVacancy->viewVacancy($this->DadosId);
            $this->editVacancyOpeningViewPriv();
        }
    }

    private function editVacancyOpeningViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditVacancyOpening();
            $this->Dados['select'] = $listarSelect->listAdd();

            $botao = ['view_vacancy' => ['menu_controller' => 'view-vacancy-opening', 'menu_metodo' => 'view-vacancy'],
                'list_vacancy' => ['menu_controller' => 'vacancy-opening', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/vacancyOpening/editVacancyOpening", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Só é permitida a atualização nas Situações \"Pendente ou Em andamento\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'vacancy-opening/list';
            header("Location: $UrlDestino");
        }
    }
}
