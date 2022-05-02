<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
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

    public function editTransf($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        $this->Dados['pg'] = $this->PageId;
        $this->DadosId = (int) $DadosId;
        if ((!empty($this->DadosId)) AND (!empty($this->PageId))) {
            $this->editTransfPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'transferencia/listarTransf';
            header("Location: $UrlDestino");
        }
    }

    private function editTransfPriv() {
        if (!empty($this->Dados['EditTransf'])) {
            unset($this->Dados['EditTransf']);
            $editarTransf = new \App\adms\Models\AdmsEditarTransf();
            $editarTransf->altTransf($this->Dados);
            if ($editarTransf->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
                $UrlDestino = URLADM . "transferência/listar-transf/{$this->PageId}";
                header("Location: $UrlDestino");
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
            $UrlDestino = URLADM . 'transferencia/listarTransf';
            header("Location: $UrlDestino");
        }
    }

}
