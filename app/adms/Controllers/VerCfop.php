<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerCfop {

    private $Dados;
    private $DadosId;

    public function verCfop($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verCfop = new \App\adms\Models\AdmsVerCfop();
            $this->Dados['dados_cfop'] = $verCfop->verCfop($this->DadosId);

            $botao = ['list_cfop' => ['menu_controller' => 'cfop', 'menu_metodo' => 'listar'],
                'edit_cfop' => ['menu_controller' => 'editar-cfop', 'menu_metodo' => 'edit-cfop'],
                'del_cfop' => ['menu_controller' => 'apagar-cfop', 'menu_metodo' => 'apagar-cfop']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/faq/verCfop", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cfop não encontrado!</div>";
            $UrlDestino = URLADM . 'cor/listar';
            header("Location: $UrlDestino");
        }
    }

}
