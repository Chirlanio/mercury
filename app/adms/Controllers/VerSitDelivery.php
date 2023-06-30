<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerSitDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerSitDelivery {

    private $Dados;
    private $DadosId;

    public function verSit($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSit = new \App\adms\Models\AdmsVerSitDelivery();
            $this->Dados['dados_sit'] = $verSit->verSit($this->DadosId);

            $botao = ['list_sit' => ['menu_controller' => 'situacao-delivery', 'menu_metodo' => 'listar'],
                'edit_sit' => ['menu_controller' => 'editar-sit-delivery', 'menu_metodo' => 'edit-sit'],
                'del_sit' => ['menu_controller' => 'apagar-sit-delivery', 'menu_metodo' => 'apagar-sit']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/situacaoDelivery/verSit", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação não encontrada!</div>";
            $UrlDestino = URLADM . 'situacao-delivery/listar';
            header("Location: $UrlDestino");
        }
    }

}
