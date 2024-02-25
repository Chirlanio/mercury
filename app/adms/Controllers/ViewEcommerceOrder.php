<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewEcommerceOrder
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewEcommerceOrder {

    private $Dados;
    private $DadosId;

    public function viewOrder($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {

            $viewOrder = new \App\adms\Models\AdmsViewEcommerceOrder();
            $this->Dados['dados_ecommerce'] = $viewOrder->viewOrder($this->DadosId);

            $botao = ['list_ecommerce_order' => ['menu_controller' => 'ecommerce', 'menu_metodo' => 'list'],
                'edit_ecommerce_order' => ['menu_controller' => 'edit-ecommerce-order', 'menu_metodo' => 'edit-order'],
                'del_ecommerce_order' => ['menu_controller' => 'delete-ecommerce-order', 'menu_metodo' => 'delete-order']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/ecommerce/viewEcommerceOrder", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ecommerce/list';
            header("Location: $UrlDestino");
        }
    }
}
