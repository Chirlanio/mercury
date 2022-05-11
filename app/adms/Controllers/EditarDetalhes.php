<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarDashboard {

    private $Dados;
    private $DadosId;

    public function editDashboard($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editDashboardPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'dashboard/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editDashboardPriv() {
        if (!empty($this->Dados['EditDash'])) {
            unset($this->Dados['EditDash'], $this->Dados['sit_id'], $this->Dados['nome_sit'], $this->Dados['area']);
            $editarDash = new \App\adms\Models\AdmsEditarDashboard();
            $editarDash->altDashboard($this->Dados);
            if ($editarDash->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Dashboard atualizado com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-dashboard/ver-dashboard/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editDashboardViewPriv();
            }
        } else {
            $verDash = new \App\adms\Models\AdmsEditarDashboard();
            $this->Dados['form'] = $verDash->verDashboard($this->DadosId);
            $this->editDashboardViewPriv();
        }
    }

    private function editDashboardViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarDashboard();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_dash' => ['menu_controller' => 'ver-dashboard', 'menu_metodo' => 'ver-dashboard']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/dashboard/editarDashboard", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Dashboard não encontrado!</div>";
            $UrlDestino = URLADM . 'dashboard/listar';
            header("Location: $UrlDestino");
        }
    }

}
