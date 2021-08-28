<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarLoja
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarLoja {

    private $Dados;
    private $DadosId;

    public function editLoja($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editLojaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Loja não encontrada!</div>";
            $UrlDestino = URLADM . 'lojas/listarLojas';
            header("Location: $UrlDestino");
        }
    }

    private function editLojaPriv() {
        if (!empty($this->Dados['EditLoja'])) {
            unset($this->Dados['EditLoja']);
            $editarLoja = new \App\adms\Models\AdmsEditarLoja();
            $editarLoja->altLoja($this->Dados);
            if ($editarLoja->getResultado()) {
                $UrlDestino = URLADM . 'lojas/listarLojas';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editLojaViewPriv();
            }
        } else {
            $verLoja = new \App\adms\Models\AdmsEditarLoja();
            $this->Dados['form'] = $verLoja->verLoja($this->DadosId);
            $this->editLojaViewPriv();
        }
    }

    private function editLojaViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarLoja();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_loja' => ['menu_controller' => 'ver-loja', 'menu_metodo' => 'ver-loja']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/loja/editarLojas", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'lojas/listarLojas';
            header("Location: $UrlDestino");
        }
    }

}
