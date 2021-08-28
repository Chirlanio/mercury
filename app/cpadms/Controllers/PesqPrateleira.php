<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqPrateleira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqPrateleira {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_ped' => ['menu_controller' => 'prateleira-infinita', 'menu_metodo' => 'listar'],
            'cad_ped' => ['menu_controller' => 'cadastrar-ped', 'menu_metodo' => 'cad-ped'],
            'vis_ped' => ['menu_controller' => 'ver-ped', 'menu_metodo' => 'ver-dashboard'],
            'edit_ped' => ['menu_controller' => 'editar-ped', 'menu_metodo' => 'edit-ped'],
            'del_ped' => ['menu_controller' => 'apagar-ped', 'menu_metodo' => 'apagar-ped']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqPed();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->DadosForm['PesqPed'])) {
            unset($this->DadosForm['PesqPed']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['loja_id'] = filter_input(INPUT_GET, 'loja', FILTER_DEFAULT);
            $this->DadosForm['referencia'] = filter_input(INPUT_GET, 'referencia', FILTER_DEFAULT);
            $this->DadosForm['status_id'] = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
        }

        $listarPed = new \App\cpadms\Models\CpAdmsPesqPed();
        $this->Dados['listPed'] = $listarPed->pesqPed($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarPed->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/prateleira/pesqPrateleira", $this->Dados);
        $carregarView->renderizar();
    }

}
