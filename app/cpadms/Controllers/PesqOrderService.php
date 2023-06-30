<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqOrderService
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqOrderService {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_order_service' => ['menu_controller' => 'ordem-servico', 'menu_metodo' => 'listar'],
            'cad_order_service' => ['menu_controller' => 'cadastrar-ordem-servico', 'menu_metodo' => 'cad-ordem-servico'],
            'vis_order_service' => ['menu_controller' => 'ver-ordem-servico', 'menu_metodo' => 'ver-ordem-servico'],
            'edit_order_service' => ['menu_controller' => 'editar-ordem-servico', 'menu_metodo' => 'edit-ordem-servico'],
            'del_order_service' => ['menu_controller' => 'apagar-ordem-servico', 'menu_metodo' => 'apagar-ordem-servico']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqOrderService'])) {
            unset($this->DadosForm['PesqOrderService']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'pesquisar', FILTER_DEFAULT);
        }

        $listarPagina = new \App\cpadms\Models\CpAdmsPesqOrderService();
        $this->Dados['listOrderService'] = $listarPagina->listar($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarPagina->getResultadoAj();

        $carregarView = new \Core\ConfigView("cpadms/Views/ordemServico/pesqOrderService", $this->Dados);
        $carregarView->renderizar();
    }

}
