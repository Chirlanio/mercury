<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarRota
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class EditarRota {

    private $Dados;
    private $DadosId;

    public function editRota($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editRotaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Rota não encontrada!</div>";
            $UrlDestino = URLADM . 'rota/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editRotaPriv() {

        if (!empty($this->Dados['EditRota'])) {
            unset($this->Dados['EditRota']);

            $editarRota = new \App\adms\Models\AdmsEditarRota();
            $editarRota->altRota($this->Dados);

            if ($editarRota->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Rota editada com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-rota/ver-rota/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editRotaViewPriv();
            }
        } else {
            $verRota = new \App\adms\Models\AdmsEditarRota();
            $this->Dados['form'] = $verRota->verRota($this->DadosId);
            $this->editRotaViewPriv();
        }
    }

    private function editRotaViewPriv() {

        if ($this->Dados['form']) {
            $botao = ['vis_rota' => ['menu_controller' => 'ver-rota', 'menu_metodo' => 'ver-rota']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $listarSelect = new \App\adms\Models\AdmsEditarRota();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $carregarView = new \Core\ConfigView("adms/Views/rota/editarRota", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Rota não encontrada!</div>";
            $UrlDestino = URLADM . 'rota/listar';
            header("Location: $UrlDestino");
        }
    }

}
