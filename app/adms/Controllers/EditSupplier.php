<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditSupplier {

    private $Dados;
    private $DadosId;

    public function editSupplier($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editSupplierPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Fornecedor não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'supplier/list';
            header("Location: $UrlDestino");
        }
    }

    private function editSupplierPriv() {
        if (!empty($this->Dados['EditSupplier'])) {
            unset($this->Dados['EditSupplier']);
            $editarSupplier = new \App\adms\Models\AdmsEditSupplier();
            $editarSupplier->altSupplier($this->Dados);
            if ($editarSupplier->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Fornecedor</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'view-supplier/view-supplier/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSupplierViewPriv();
            }
        } else {
            $viewSupplier = new \App\adms\Models\AdmsEditSupplier();
            $this->Dados['form'] = $viewSupplier->viewSupplier($this->DadosId);
            $this->editSupplierViewPriv();
        }
    }

    private function editSupplierViewPriv() {
        if ($this->Dados['form']) {
            
            $listSelect = new \App\adms\Models\AdmsEditSupplier();
            $this->Dados['select'] = $listSelect->listAdd();
            
            $botao = ['list_supplier' => ['menu_controller' => 'supplier', 'menu_metodo' => 'list'],'view_supplier' => ['menu_controller' => 'view-supplier', 'menu_metodo' => 'view-supplier']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/supplier/editSupplier", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Fornecedor não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'supplier/list';
            header("Location: $UrlDestino");
        }
    }

}
