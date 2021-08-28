<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqEstoque
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqEstoque {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_estoque' => ['menu_controller' => 'estoque', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\cpadms\Models\CpAdmsPesqEstoque();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqEst'])) {
            unset($this->DadosForm['PesqEst']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['referencia'] = filter_input(INPUT_GET, 'referencia', FILTER_DEFAULT);
            $this->DadosForm['refauxiliar'] = filter_input(INPUT_GET, 'refauxiliar', FILTER_DEFAULT);
            $this->DadosForm['loja_id'] = filter_input(INPUT_GET, 'loja_id', FILTER_DEFAULT);
        }
        $listarProdutos = new \App\cpadms\Models\CpAdmsPesqEstoque();
        $this->Dados['listEstoque'] = $listarProdutos->pesqEstoque($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarProdutos->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/estoque/pesqEstoque", $this->Dados);
        $carregarView->renderizar();
    }

}
