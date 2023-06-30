<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarBalancoProduto {

    private $Dados;

    public function cadProduto() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadBalanco'])) {
            unset($this->Dados['CadBalanco']);
            $cadProduto = new \App\adms\Models\AdmsCadastrarBalancoProduto();
            $cadProduto->cadProduto($this->Dados);
            if ($cadProduto->getResultado()) {
                $UrlDestino = URLADM . 'balanco-produto/listar/?id=' . $_SESSION['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadBalancoProdutoViewPriv();
            }
        } else {
            $this->cadBalancoProdutoViewPriv();
        }
    }

    private function cadBalancoProdutoViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarBalancoProduto();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_balanco' => ['menu_controller' => 'balanco-produto', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/auditoria/cadBalancoProduto", $this->Dados);
        $carregarView->renderizar();
    }

}
