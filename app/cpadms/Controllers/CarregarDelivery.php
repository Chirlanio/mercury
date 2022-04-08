<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CarregarDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CarregarDelivery {

    private $Dados;
    private $PageId;
    private $TipoResultado;
    private $PesqDelivery;

    public function listar($PageId = null) {
        $this->TipoResultado = filter_input(INPUT_GET, 'tiporesult');
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['vis_delivery' => ['menu_controller' => 'ver-delivery-modal', 'menu_metodo' => 'ver-delivery']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        if (!empty($this->TipoResultado) AND ( $this->TipoResultado == 1)) {
            $this->listarDeliveryPriv();
        } elseif (!empty($this->TipoResultado) AND ( $this->TipoResultado == 2)) {
            $this->PesqDelivery = filter_input(INPUT_POST, 'palavraPesq');
            $this->pesqDeliveryPriv();
        } else {
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $listarSelect = new \App\cpadms\Models\CpAdmsCadastrarUsuario();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/delivery/carregarDelivery", $this->Dados);
            $carregarView->renderizar();
        }
    }

    private function listarDeliveryPriv() {

        $listarDelivery = new \App\cpadms\Models\CpAdmsListarDelivery();
        $this->Dados['listDelivery'] = $listarDelivery->listarDelivery($this->PageId);
        $this->Dados['paginacao'] = $listarDelivery->getResultadoPg();

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/delivery/listarDelivery", $this->Dados);
        $carregarView->renderizarListar();
    }

    private function pesqDeliveryPriv() {

        $listarDelivery = new \App\cpadms\Models\CpAdmsPesqDelivery();
        $this->Dados['listDelivery'] = $listarDelivery->pesqDelivery($this->PesqDelivery);
        $this->Dados['paginacao'] = $listarDelivery->getResultadoPg();

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/delivery/listarUsuarioJs", $this->Dados);
        $carregarView->renderizarListar();
    }

}
