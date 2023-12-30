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
            'gerar' => ['menu_controller' => 'gerar-planilha-order-service', 'menu_metodo' => 'gerar'],
            'cad_order_service' => ['menu_controller' => 'cadastrar-ordem-servico', 'menu_metodo' => 'cad-ordem-servico'],
            'vis_order_service' => ['menu_controller' => 'ver-ordem-servico', 'menu_metodo' => 'ver-ordem-servico'],
            'edit_order_service' => ['menu_controller' => 'editar-ordem-servico', 'menu_metodo' => 'edit-ordem-servico'],
            'del_order_service' => ['menu_controller' => 'apagar-ordem-servico', 'menu_metodo' => 'apagar-ordem-servico']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqOrderService();
        $this->Dados['select'] = $listarSelect->listCad();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqOrderService'])) {
            unset($this->DadosForm['PesqOrderService']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['loja_id'] = filter_input(INPUT_GET, 'loja', FILTER_DEFAULT);
            $this->DadosForm['min_id'] = filter_input(INPUT_GET, 'min_id', FILTER_DEFAULT);
            $this->DadosForm['max_id'] = filter_input(INPUT_GET, 'max_id', FILTER_DEFAULT);
            $this->DadosForm['sit_id'] = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
            $this->DadosForm['cliente'] = filter_input(INPUT_GET, 'cliente', FILTER_DEFAULT);
        }

        $this->Dados['search'] = $this->DadosForm;

        $listarPagina = new \App\cpadms\Models\CpAdmsPesqOrderService();
        $this->Dados['listOrderService'] = $listarPagina->listar($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarPagina->getResultadoAj();

        $carregarView = new \Core\ConfigView("cpadms/Views/ordemServico/pesqOrderService", $this->Dados);
        $carregarView->renderizar();
    }

}
