<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqProdutos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqProdutos {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_produtos' => ['menu_controller' => 'produtos', 'menu_metodo' => 'listar-produtos'],
            'vis_produtos' => ['menu_controller' => 'ver-produto', 'menu_metodo' => 'ver-produto'],
            'edit_produtos' => ['menu_controller' => 'editar-produto', 'menu_metodo' => 'edit-produto'],
            'del_produtos' => ['menu_controller' => 'apagar-produto', 'menu_metodo' => 'apagar-produto']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqProd'])) {
            unset($this->DadosForm['PesqProd']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['referencia'] = filter_input(INPUT_GET, 'referencia', FILTER_DEFAULT);
            $this->DadosForm['codbarras'] = filter_input(INPUT_GET, 'refauxiliar', FILTER_DEFAULT);
        }
        $listarProdutos = new \App\cpadms\Models\CpAdmsPesqProdutos();
        $this->Dados['listProdutos'] = $listarProdutos->pesqProdutos($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarProdutos->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/produtos/pesqProdutos", $this->Dados);
        $carregarView->renderizar();
    }

}
