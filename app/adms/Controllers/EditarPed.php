<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarPed
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarPed {

    private $Dados;
    private $DadosId;

    public function editPed($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editPedPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'prateleira-infinita/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editPedPriv() {
        if (!empty($this->Dados['EditPed'])) {
            unset($this->Dados['EditPed']);
            $editarPed = new \App\adms\Models\AdmsEditarPed();
            $editarPed->altPed($this->Dados);
            if ($editarPed->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Pedido atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'prateleira-infinita/listar/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editPedViewPriv();
            }
        } else {
            $editarPed = new \App\adms\Models\AdmsEditarPed();
            $this->Dados['form'] = $editarPed->verPed($this->DadosId);
            $this->editPedViewPriv();
        }
    }

    private function editPedViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarPed();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_ped' => ['menu_controller' => 'prateleira-infinita', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/prateleira/editarPed", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O pedido não foi encontrado!</div>";
            $UrlDestino = URLADM . 'prateleira-infinita/listar';
            header("Location: $UrlDestino");
        }
    }

}
