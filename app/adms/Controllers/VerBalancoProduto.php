<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerBalancoProduto {

    private $Dados;
    private $DadosId;

    public function verBalanco($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verBalanco = new \App\adms\Models\AdmsVerBalancoProduto();
            $this->Dados['dados_balanco'] = $verBalanco->verBalanco($this->DadosId);

            $botao = ['list_balanco_produto' => ['menu_controller' => 'balanco', 'menu_metodo' => 'listar'],
                'vis_balanco_produto' => ['menu_controller' => 'ver-balanco-produto', 'menu_metodo' => 'ver-balanco'],
                'edit_balanco_produto' => ['menu_controller' => 'editar-balanco-produto', 'menu_metodo' => 'edit-balanco'],
                'del_balanco_produto' => ['menu_controller' => 'apagar-balanco-produto', 'menu_metodo' => 'apagar-balanco']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/auditoria/verBalancoProduto", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Produto não encontrado!</div>";
            $UrlDestino = URLADM . 'balanco-produto/listar';
            header("Location: $UrlDestino");
        }
    }

}
