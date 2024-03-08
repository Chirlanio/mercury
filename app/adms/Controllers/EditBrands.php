<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditBrands
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditBrands {

    private $Dados;
    private $DadosId;

    public function editBrand($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editBrandPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Marca não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'brands/list';
            header("Location: $UrlDestino");
        }
    }

    private function editBrandPriv() {
        if (!empty($this->Dados['EditBrand'])) {
            unset($this->Dados['EditBrand']);
            $editarBrand = new \App\adms\Models\AdmsEditBrand();
            $editarBrand->altBrand($this->Dados);
            if ($editarBrand->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Marca</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'brands/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editBrandViewPriv();
            }
        } else {
            $viewBrand = new \App\adms\Models\AdmsEditBrand();
            $this->Dados['form'] = $viewBrand->viewBrand($this->DadosId);
            $this->editBrandViewPriv();
        }
    }

    private function editBrandViewPriv() {
        if ($this->Dados['form']) {
            
            $listSelect = new \App\adms\Models\AdmsEditBrand();
            $this->Dados['select'] = $listSelect->listAdd();
            
            $botao = ['list_brand' => ['menu_controller' => 'brands', 'menu_metodo' => 'list'],'view_brand' => ['menu_controller' => 'view-brands', 'menu_metodo' => 'view-brand']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/brand/editBrand", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Marca não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'brands/list';
            header("Location: $UrlDestino");
        }
    }

}
