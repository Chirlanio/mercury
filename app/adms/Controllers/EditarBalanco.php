<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarBalanco {

    private $Dados;
    private $DadosId;

    public function editBalanco($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editBalancoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'balanco/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editBalancoPriv() {
        if (!empty($this->Dados['EditBalanco'])) {
            unset($this->Dados['EditBalanco']);
            $editarBalanco = new \App\adms\Models\AdmsEditarBalanco();
            $editarBalanco->altBalanco($this->Dados);
            
            if ($editarBalanco->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'balanco/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editBalancoViewPriv();
            }
        } else {
            $verBalanco = new \App\adms\Models\AdmsEditarBalanco();
            $this->Dados['form'] = $verBalanco->verBalanco($this->DadosId);
            $this->editBalancoViewPriv();
        }
    }

    private function editBalancoViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarBalanco();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_balanco' => ['menu_controller' => 'editar-balanco', 'menu_metodo' => 'edit-balanco']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/auditoria/editarBalanco", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Só é permitido editar balanços com o status \"Pendente\" ou \"Em Analise\"!</div>";
            $UrlDestino = URLADM . 'balanco/listar';
            header("Location: $UrlDestino");
        }
    }

}
