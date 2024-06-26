<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarSitOrderPayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarSitOrderPayment {

    private $Dados;
    private $DadosId;

    public function editSit($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Situação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'situacao-order-payment/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitPriv() {
        if (!empty($this->Dados['EditSit'])) {
            unset($this->Dados['EditSit']);
            $editarSit = new \App\adms\Models\AdmsEditarSitOrderPayment();
            $editarSit->altSit($this->Dados);
            if ($editarSit->getResultado()) {
                $UrlDestino = URLADM . 'situacao-order-payment/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitViewPriv();
            }
        } else {
            $verSit = new \App\adms\Models\AdmsEditarSitOrderPayment();
            $this->Dados['form'] = $verSit->verSit($this->DadosId);
            $this->editSitViewPriv();
        }
    }

    private function editSitViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarSitOrderPayment();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_sit' => ['menu_controller' => 'situacao-order-payment', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/situacaoOrderPayment/editarSitOrderPayment", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Situação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'situacao-order-payment/listar';
            header("Location: $UrlDestino");
        }
    }

}
