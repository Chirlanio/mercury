<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerBandeira {

    private $Dados;
    private $DadosId;

    public function verBandeira($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verBandeira = new \App\adms\Models\AdmsVerBandeira();
            $this->Dados['dados_bandeira'] = $verBandeira->verBandeira($this->DadosId);

            $botao = ['list_bandeira' => ['menu_controller' => 'bandeira', 'menu_metodo' => 'listar'],
                'edit_bandeira' => ['menu_controller' => 'editar-bandeira', 'menu_metodo' => 'edit-bandeira'],
                'del_bandeira' => ['menu_controller' => 'apagar-bandeira', 'menu_metodo' => 'apagar-bandeira']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/bandeira/verBandeira", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Bandeira não encontrada!</div>";
            $UrlDestino = URLADM . 'bandeira/listar';
            header("Location: $UrlDestino");
        }
    }

}
