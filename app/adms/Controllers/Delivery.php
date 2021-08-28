<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Delivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Delivery {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_delivery' => ['menu_controller' => 'cadastrar-delivery', 'menu_metodo' => 'cad-delivery'],
            'gerar' => ['menu_controller' => 'gerar-planilha', 'menu_metodo' => 'gerar'],
            'vis_delivery' => ['menu_controller' => 'ver-delivery', 'menu_metodo' => 'ver-delivery'],
            'edit_delivery' => ['menu_controller' => 'editar-delivery', 'menu_metodo' => 'edit-delivery'],
            'del_delivery' => ['menu_controller' => 'apagar-delivery', 'menu_metodo' => 'apagar-delivery']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsListarDelivery();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarDelivery = new \App\adms\Models\AdmsListarDelivery();
        $this->Dados['listDelivery'] = $listarDelivery->listarDelivery($this->PageId);
        $this->Dados['paginacao'] = $listarDelivery->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/delivery/listarDelivery", $this->Dados);
        $carregarView->renderizar();
    }

}
