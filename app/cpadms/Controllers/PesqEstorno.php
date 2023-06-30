<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqEstorno {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_estorno' => ['menu_controller' => 'estorno', 'menu_metodo' => 'listar'],
            'cad_estorno' => ['menu_controller' => 'cadastrar-estorno', 'menu_metodo' => 'cad-estorno'],
            'vis_estorno' => ['menu_controller' => 'ver-estorno', 'menu_metodo' => 'ver-estorno'],
            'edit_estorno' => ['menu_controller' => 'editar-estorno', 'menu_metodo' => 'edit-estorno'],
            'del_estorno' => ['menu_controller' => 'apagar-estorno', 'menu_metodo' => 'apagar-estorno']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqEstorno'])) {
            unset($this->DadosForm['PesqEstorno']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'pesquisar', FILTER_DEFAULT);
        }

        $listarPagina = new \App\cpadms\Models\CpAdmsPesqEstorno();
        $this->Dados['listEstorno'] = $listarPagina->listar($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarPagina->getResultadoAj();

        $carregarView = new \Core\ConfigView("cpadms/Views/estorno/pesqEstorno", $this->Dados);
        $carregarView->renderizar();
    }

}
