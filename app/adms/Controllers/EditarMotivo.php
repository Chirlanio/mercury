<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarMotivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarMotivo {

    private $Dados;
    private $DadosId;

    public function editMotivo($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editMotivoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Motivo de estorno não encontrado!</div>";
            $UrlDestino = URLADM . 'motivo-estorno/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editMotivoPriv() {
        if (!empty($this->Dados['EditMotivo'])) {
            unset($this->Dados['EditMotivo']);
            $editarMotivo = new \App\adms\Models\AdmsEditarMotivo();
            $editarMotivo->altMotivo($this->Dados);
            if ($editarMotivo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Motivo de estorno atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'motivo-estorno/listar/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMotivoViewPriv();
            }
        } else {
            $verMotivo = new \App\adms\Models\AdmsEditarMotivo();
            $this->Dados['form'] = $verMotivo->verMotivo($this->DadosId);
            $this->editMotivoViewPriv();
        }
    }

    private function editMotivoViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['list_motivo' => ['menu_controller' => 'motivo-estorno', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/motivo/editarMotivo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Motivo de estorno não encontrado!</div>";
            $UrlDestino = URLADM . 'motivo-estorno/listar';
            header("Location: $UrlDestino");
        }
    }

}
