<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerDashboard {

    private $Dados;
    private $DadosId;

    public function verDashboard($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verDash = new \App\adms\Models\AdmsVerDashboard();
            $this->Dados['dados_dash'] = $verDash->verDashboard($this->DadosId);

            $botao = ['list_dash' => ['menu_controller' => 'dashboard', 'menu_metodo' => 'listar'],
                'edit_dash' => ['menu_controller' => 'editar-dashboard', 'menu_metodo' => 'edit-dashboard'],
                'del_dash' => ['menu_controller' => 'apagar-dashboard', 'menu_metodo' => 'apagar-dashboard']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/dashboard/verDashboard", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Dashboard não encontrado!</div>";
            $UrlDestino = URLADM . 'dashboard/listar';
            header("Location: $UrlDestino");
        }
    }

}
