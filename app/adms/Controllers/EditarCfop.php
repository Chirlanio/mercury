<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarCfop
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class EditarCfop {

    private $Dados;
    private $DadosId;

    public function editCfop($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editCfopPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cfop não encontrado!</div>";
            $UrlDestino = URLADM . 'cfop/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editCfopPriv() {
        if (!empty($this->Dados['EditCfop'])) {
            unset($this->Dados['EditCfop']);
            $editarCfop = new \App\adms\Models\AdmsEditarCfop();
            $editarCfop->altCfop($this->Dados);
            if ($editarCfop->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Cfop editado com sucesso!</div>";
                $UrlDestino = URLADM . 'cfop/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCfopViewPriv();
            }
        } else {
            $verCfop = new \App\adms\Models\AdmsEditarCfop();
            $this->Dados['form'] = $verCfop->verCfop($this->DadosId);
            $this->editCfopViewPriv();
        }
    }

    private function editCfopViewPriv() {
        if ($this->Dados['form']) {
            $botao = ['vis_cfop' => ['menu_controller' => 'ver-cfop', 'menu_metodo' => 'ver-cfop']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/faq/editarCfop", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cfop não encontrado!</div>";
            $UrlDestino = URLADM . 'cfop/listar';
            header("Location: $UrlDestino");
        }
    }

}
