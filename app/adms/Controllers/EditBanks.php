<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditBanks
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditBanks {

    private $Dados;
    private $DadosId;

    public function editBank($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editBankPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Banco não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'banks/list';
            header("Location: $UrlDestino");
        }
    }

    private function editBankPriv() {
        if (!empty($this->Dados['EditBank'])) {
            unset($this->Dados['EditBank']);
            $editarBank = new \App\adms\Models\AdmsEditBank();
            $editarBank->altBank($this->Dados);
            if ($editarBank->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'banks/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editBankViewPriv();
            }
        } else {
            $viewBrand = new \App\adms\Models\AdmsEditBank();
            $this->Dados['form'] = $viewBrand->viewBank($this->DadosId);
            $this->editBankViewPriv();
        }
    }

    private function editBankViewPriv() {
        if ($this->Dados['form']) {
            
            $listSelect = new \App\adms\Models\AdmsEditBank();
            $this->Dados['select'] = $listSelect->listAdd();
            
            $botao = ['list_bank' => ['menu_controller' => 'banks', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/bank/editBank", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> cadastro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'banks/list';
            header("Location: $UrlDestino");
        }
    }

}
