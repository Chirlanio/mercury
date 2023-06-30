<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerLoja
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerLoja {

    private $Dados;
    private $DadosId;

    public function verLoja($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verLoja = new \App\adms\Models\AdmsVerLoja();
            $this->Dados['dados_loja'] = $verLoja->verLoja($this->DadosId);

            $botao = ['list_loja' => ['menu_controller' => 'lojas', 'menu_metodo' => 'listar-lojas'],
                'edit_loja' => ['menu_controller' => 'editar-loja', 'menu_metodo' => 'edit-loja'],
                'del_loja' => ['menu_controller' => 'apagar-loja', 'menu_metodo' => 'apagar-loja']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/loja/verLoja", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Loja não encontrada!</div>";
            $UrlDestino = URLADM . 'lojas/listarLojas';
            header("Location: $UrlDestino");
        }
    }

}
