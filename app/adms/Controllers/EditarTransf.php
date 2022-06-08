<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarTransf {

    private $Dados;
    private $DadosId;
    private $PageId;
    private $Origem;
    private $Destino;
    private $Status;

    public function editTransf($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->Origem = filter_input(INPUT_GET, "origem", FILTER_SANITIZE_STRING);
        $this->Dados['origem'] = $this->Origem;

        $this->Destino = filter_input(INPUT_GET, "destino", FILTER_SANITIZE_STRING);
        $this->Dados['destino'] = $this->Destino;

        $this->Status = filter_input(INPUT_GET, "status", FILTER_SANITIZE_STRING);
        $this->Dados['status'] = $this->Status;

        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        $this->Dados['pg'] = $this->PageId;

        $this->DadosId = (int) $DadosId;
        if ((!empty($this->DadosId)) and (!empty($this->PageId))) {
            $this->editTransfPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'transferencia/listarTransf';
            header("Location: $UrlDestino");
        }
    }

    private function editTransfPriv() {
        if ((!empty($this->Dados['EditTransf'])) and (!empty($this->Dados['pg']))) {
            unset($this->Dados['EditTransf'], $this->Dados['origem'], $this->Dados['pg'], $this->Dados['destino'], $this->Dados['status']);
            $editarTransf = new \App\adms\Models\AdmsEditarTransf();
            $editarTransf->altTransf($this->Dados);
            if ($editarTransf->getResultado()) {
                $this->urlDestino();
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTransfViewPriv();
            }
        } else {
            $verTransf = new \App\adms\Models\AdmsEditarTransf();
            $this->Dados['form'] = $verTransf->verTransf($this->DadosId);
            $this->editTransfViewPriv();
        }
    }

    private function urlDestino() {
        if (!empty($this->Origem)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
            $UrlDestino = URLADM . "pesq-transf/listar/{$this->PageId}?origem={$this->Origem}";
        } elseif (!empty($this->Destino)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
            $UrlDestino = URLADM . "pesq-transf/listar/{$this->PageId}?destino={$this->Destino}";
        } elseif (!empty($this->Status)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
            $UrlDestino = URLADM . "pesq-transf/listar/{$this->PageId}?status={$this->Status}";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
            $UrlDestino = URLADM . "transferência/listar-transf/{$this->PageId}";
        }
        header("Location: $UrlDestino");
    }

    private function editTransfViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarTransf();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_transf' => ['menu_controller' => 'ver-transf', 'menu_metodo' => 'ver-transf'], 'list_transf' => ['menu_controller' => 'transferencia', 'menu_metodo' => 'listar-transf']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/transferencia/editarTransf", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Não é permitido alterar transferências com o status \"Recolhido\"!</div>";
            $UrlDestino = URLADM . 'transferencia/listar-transf';
            header("Location: $UrlDestino");
        }
    }

}
