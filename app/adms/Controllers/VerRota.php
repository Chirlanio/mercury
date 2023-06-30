<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerRota {

    private $Dados;
    private $DadosId;

    public function verRota($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $verRota = new \App\adms\Models\AdmsVerRota();
            $this->Dados['dados_rota'] = $verRota->verRota($this->DadosId);

            $botao = ['list_rota' => ['menu_controller' => 'rota', 'menu_metodo' => 'listar'],
                'edit_rota' => ['menu_controller' => 'editar-rota', 'menu_metodo' => 'edit-rota'],
                'del_rota' => ['menu_controller' => 'apagar-rota', 'menu_metodo' => 'apagar-rota']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/rota/verRota", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Rota não encontrada!</div>";
            $UrlDestino = URLADM . 'rota/listar';
            header("Location: $UrlDestino");
        }
    }

}
