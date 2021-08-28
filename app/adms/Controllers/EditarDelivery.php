<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarDelivery {

    private $Dados;
    private $DadosId;

    public function editDelivery($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editDeliveryPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'delivery/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editDeliveryPriv() {

        if (!empty($this->Dados['EditDelivery'])) {
            unset($this->Dados['EditDelivery']);

            $editarDelivery = new \App\adms\Models\AdmsEditarDelivery();
            $editarDelivery->altDelivery($this->Dados);

            if ($editarDelivery->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-delivery/ver-delivery/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editDeliveryViewPriv();
            }
        } else {
            $verDelivery = new \App\adms\Models\AdmsEditarDelivery();
            $this->Dados['form'] = $verDelivery->verDelivery($this->DadosId);
            $this->editDeliveryViewPriv();
        }
    }

    private function editDeliveryViewPriv() {

        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditarDelivery();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_delivery' => ['menu_controller' => 'editar-delivery', 'menu_metodo' => 'edit-delivery']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/delivery/editarDelivery", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitações não encontrada!</div>";
            $UrlDestino = URLADM . 'delivery/listarDelivery';
            header("Location: $UrlDestino");
        }
    }
}
