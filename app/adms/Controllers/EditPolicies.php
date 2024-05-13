<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditPolicies
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditPolicies {

    private $Dados;
    private $DadosId;

    public function editPolicie($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editPoliciePriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'policies/list';
            header("Location: $UrlDestino");
        }
    }

    private function editPoliciePriv() {
        if (!empty($this->Dados['EditPolicie'])) {
            unset($this->Dados['EditPolicie']);
            $this->Dados['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $this->Dados['file_name'] = ($_FILES['file_name'] ? $_FILES['file_name'] : null);

            $editPolicie = new \App\adms\Models\AdmsEditPolicies();
            $editPolicie->altPolicie($this->Dados);

            if ($editPolicie->getResultado()) {
                $UrlDestino = URLADM . 'view-policies/view-policie/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editPoliciesViewPriv();
            }
        } else {
            $viewPolicie = new \App\adms\Models\AdmsEditPolicies();
            $this->Dados['form'] = $viewPolicie->viewPolicie($this->DadosId);
            $this->editPoliciesViewPriv();
        }
    }

    private function editPoliciesViewPriv() {
        if ($this->Dados['form']) {

            $listSelect = new \App\adms\Models\AdmsEditPolicies();
            $this->Dados['select'] = $listSelect->listAdd();

            $botao = ['view_policies' => ['menu_controller' => 'view-policies', 'menu_metodo' => 'view-policie'],
                'list_policies' => ['menu_controller' => 'policies', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/policies/editPolicies", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'policies/list';
            header("Location: $UrlDestino");
        }
    }
}
