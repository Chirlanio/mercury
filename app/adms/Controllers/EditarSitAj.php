<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarSitAj
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarSitAj {

    private $Dados;
    private $DadosId;

    public function editSit($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação não encontrada!</div>";
            $UrlDestino = URLADM . 'situacao-ajuste/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitPriv() {
        if (!empty($this->Dados['EditSit'])) {
            unset($this->Dados['EditSit']);
            $editarSit = new \App\adms\Models\AdmsEditarSitAj();
            $editarSit->altSit($this->Dados);
            if ($editarSit->getResultado()) {
                $UrlDestino = URLADM . 'ver-sit-aj/ver-sit/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitViewPriv();
            }
        } else {
            $verSit = new \App\adms\Models\AdmsEditarSitAj();
            $this->Dados['form'] = $verSit->verSit($this->DadosId);
            $this->editSitViewPriv();
        }
    }

    private function editSitViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarSitAj();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_sit' => ['menu_controller' => 'ver-sit-aj', 'menu_metodo' => 'ver-sit']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/situacaoAj/editarSit", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação não encontrada!</div>";
            $UrlDestino = URLADM . 'situacao-ajuste/listar';
            header("Location: $UrlDestino");
        }
    }

}
