<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of class VerProduto {
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerProduto {

    private $Dados;
    private $DadosId;

    public function verProduto($DadosId = null) {

        $this->DadosId = $DadosId;
        
        if (!empty($this->DadosId)) {
            $verProduto = new \App\adms\Models\AdmsVerProduto();
            $this->Dados['dados_produto'] = $verProduto->verProduto($this->DadosId);

            $botao = ['list_produtos' => ['menu_controller' => 'produtos', 'menu_metodo' => 'listar'],
                'edit_produtos' => ['menu_controller' => 'editar-produto', 'menu_metodo' => 'edit-produto'],
                'del_produtos' => ['menu_controller' => 'apagar-produto', 'menu_metodo' => 'apagar-produto']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/produtos/verProduto", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Produto não encontrado!</div>";
            $UrlDestino = URLADM . 'produtos/listarProdutos';
            header("Location: $UrlDestino");
        }
    }

}
