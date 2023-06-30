<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarAjuste {

    private $Dados;
    private $DadosId;

    public function editAjuste($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editAjustePriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'ajuste/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editAjustePriv() {
        if (!empty($this->Dados['EditAjuste'])) {
            unset($this->Dados['EditAjuste']);
            $editarAjuste = new \App\adms\Models\AdmsEditarAjuste();
            $editarAjuste->altAjuste($this->Dados);
            //var_dump($this->Dados);
            if ($editarAjuste->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'ajuste/listar-ajuste/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editAjusteViewPriv();
            }
        } else {
            $verAjuste = new \App\adms\Models\AdmsEditarAjuste();
            $this->Dados['form'] = $verAjuste->verAjuste($this->DadosId);
            $this->editAjusteViewPriv();
        }
    }

    private function editAjusteViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarAjuste();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_ajuste' => ['menu_controller' => 'editar-ajuste', 'menu_metodo' => 'edit-ajuste']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/ajuste/editarAjuste", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Só é permitido editar solicitações de ajuste de estoque com os status \"Pendente ou Em Analise\"!</div>";
            $UrlDestino = URLADM . 'ajuste/listarAjuste';
            header("Location: $UrlDestino");
        }
    }

}
