<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarDelivery
 *
 * @copyright (c) year,  Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarDelivery {

    private $Dados;

    public function cadDelivery() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadDelivery'])) {
            unset($this->Dados['CadDelivery']);
            $cadDelivery = new \App\adms\Models\AdmsCadastrarDelivery();
            $cadDelivery->cadDelivery($this->Dados);
            if ($cadDelivery->getResultado()) {
                $UrlDestino = URLADM . 'delivery/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadDeliveryViewPriv();
            }
        } else {
            $this->cadDeliveryViewPriv();
        }
    }

    private function cadDeliveryViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarDelivery();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_delivery' => ['menu_controller' => 'delivery', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/delivery/cadDelivery", $this->Dados);
        $carregarView->renderizar();
    }

}
