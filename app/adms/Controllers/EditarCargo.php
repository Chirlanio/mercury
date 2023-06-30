<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarCor
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarCargo {

    private $Dados;
    private $DadosId;

    public function editCargo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editCargoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cargo não encontrado!</div>";
            $UrlDestino = URLADM . 'cargo/listarCargo';
            header("Location: $UrlDestino");
        }
    }

    private function editCargoPriv() {
        if (!empty($this->Dados['EditCargo'])) {
            unset($this->Dados['EditCargo']);
            $editarCargo = new \App\adms\Models\AdmsEditarCargo();
            $editarCargo->altCargo($this->Dados);
            if ($editarCargo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Cargo editado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-cargo/ver-cargo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCargoViewPriv();
            }
        } else {
            $verCargo = new \App\adms\Models\AdmsEditarCargo();
            $this->Dados['form'] = $verCargo->verCargo($this->DadosId);
            $this->editCargoViewPriv();
        }
    }

    private function editCargoViewPriv() {
        if ($this->Dados['form']) {
            $botao = ['vis_cargo' => ['menu_controller' => 'ver-cargo', 'menu_metodo' => 'ver-cargo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/cargo/editarCargo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cargo não encontrado!</div>";
            $UrlDestino = URLADM . 'cargo/listarCargo';
            header("Location: $UrlDestino");
        }
    }

}
