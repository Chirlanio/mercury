<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarSitBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarSitBalanco {

    private $Dados;
    private $DadosId;

    public function editSit($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitBalancoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'situacao-balanco/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitBalancoPriv() {
        if (!empty($this->Dados['EditSit'])) {
            unset($this->Dados['EditSit']);
            $editarSit = new \App\adms\Models\AdmsEditarSitBalanco();
            $editarSit->altSit($this->Dados);
            if ($editarSit->getResultado()) {
                $UrlDestino = URLADM . 'situacao-balanco/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitBalancoViewPriv();
            }
        } else {
            $verSit = new \App\adms\Models\AdmsEditarSitBalanco();
            $this->Dados['form'] = $verSit->verSit($this->DadosId);
            $this->editSitBalancoViewPriv();
        }
    }

    private function editSitBalancoViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['list_sit' => ['menu_controller' => 'situacao-balanco', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/situacaoBalanco/editarSitBalanco", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'situacao-balanco/listar';
            header("Location: $UrlDestino");
        }
    }

}
