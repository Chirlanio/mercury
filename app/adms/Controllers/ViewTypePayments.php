<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewTypePayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewTypePayments {

    private $Dados;
    private $DadosId;

    public function typePayment($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $viewType = new \App\adms\Models\AdmsViewTypePayment();
            $this->Dados['data_type'] = $viewType->viewType($this->DadosId);

            $botao = ['list_pay' => ['menu_controller' => 'type-payments', 'menu_metodo' => 'list'],
                'edit_pay' => ['menu_controller' => 'edit-type-payments', 'menu_metodo' => 'type-payment'],
                'del_pay' => ['menu_controller' => 'delete-type-payments', 'menu_metodo' => 'type-payment']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/typePayment/viewTypePayment", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Tipo de pagameto não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'type-payments/list';
            header("Location: $UrlDestino");
        }
    }

}
