<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarBandeira {

    private $Dados;
    private $DadosId;

    public function editBandeira($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editBandeiraPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Bandeira não encontrada!</div>";
            $UrlDestino = URLADM . 'bandeira/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editBandeiraPriv() {
        if (!empty($this->Dados['EditBandeira'])) {
            unset($this->Dados['EditBandeira']);
            $editarBandeira = new \App\adms\Models\AdmsEditarBandeira();
            $editarBandeira->altBandeira($this->Dados);
            if ($editarBandeira->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Bandeira atualizada com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-bandeira/ver-bandeira/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCargoViewPriv();
            }
        } else {
            $verBandeira = new \App\adms\Models\AdmsEditarBandeira();
            $this->Dados['form'] = $verBandeira->verBandeira($this->DadosId);
            $this->editBandeiraViewPriv();
        }
    }

    private function editBandeiraViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_bandeira' => ['menu_controller' => 'ver-bandeira', 'menu_metodo' => 'ver-bandeira'],
                'list_bandeira' => ['menu_controller' => 'bandeira', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/bandeira/editarBandeira", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Bandeira não encontrada!</div>";
            $UrlDestino = URLADM . 'bandeira/listar';
            header("Location: $UrlDestino");
        }
    }

}
