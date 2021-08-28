<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqDelivery {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_delivery' => ['menu_controller' => 'delivery', 'menu_metodo' => 'listar'],
            'gerar' => ['menu_controller' => 'gerar-planilha', 'menu_metodo' => 'gerar'],
            'cad_delivery' => ['menu_controller' => 'cadastrar-delivery', 'menu_metodo' => 'cad-delivery'],
            'vis_delivery' => ['menu_controller' => 'ver-delivery', 'menu_metodo' => 'ver-delivery'],
            'edit_delivery' => ['menu_controller' => 'editar-delivery', 'menu_metodo' => 'edit-delivery'],
            'del_delivery' => ['menu_controller' => 'apagar-delivery', 'menu_metodo' => 'apagar-delivery']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqDelivery();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqDelivery'])) {
            unset($this->DadosForm['PesqDelivery']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['loja_id'] = filter_input(INPUT_GET, 'loja', FILTER_DEFAULT);
            $this->DadosForm['rota_id'] = filter_input(INPUT_GET, 'rota', FILTER_DEFAULT);
            $this->DadosForm['sit_id'] = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
            $this->DadosForm['cliente'] = filter_input(INPUT_GET, 'cliente', FILTER_DEFAULT);
        }

        $listarDelivery = new \App\cpadms\Models\CpAdmsPesqDelivery();
        $this->Dados['listDelivery'] = $listarDelivery->pesqDelivery($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarDelivery->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/delivery/pesqDelivery", $this->Dados);
        $carregarView->renderizar();
    }

}
