<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerAjuste {

    private $Dados;
    private $DadosId;

    public function verAjuste($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verAjuste = new \App\adms\Models\AdmsVerAjuste();
            $this->Dados['dados_ajuste'] = $verAjuste->verAjuste($this->DadosId);

            $botao = ['list_ajuste' => ['menu_controller' => 'ajuste', 'menu_metodo' => 'listar-ajuste'],
                'vis_ajuste' => ['menu_controller' => 'ver-ajuste', 'menu_metodo' => 'ver-ajuste'],
                'edit_ajuste' => ['menu_controller' => 'editar-ajuste', 'menu_metodo' => 'edit-ajuste'],
                'del_ajuste' => ['menu_controller' => 'apagar-ajuste', 'menu_metodo' => 'apagar-ajuste']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/ajuste/verAjuste", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'ajuste/listarAjuste';
            header("Location: $UrlDestino");
        }
    }

}
