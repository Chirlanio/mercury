<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerCor
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerCargo {

    private $Dados;
    private $DadosId;

    public function verCargo($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verCargo = new \App\adms\Models\AdmsVerCargo();
            $this->Dados['dados_cargo'] = $verCargo->verCargo($this->DadosId);

            $botao = ['list_cargo' => ['menu_controller' => 'cargo', 'menu_metodo' => 'listarCargo'],
                'edit_cargo' => ['menu_controller' => 'editar-cargo', 'menu_metodo' => 'edit-cargo'],
                'del_cargo' => ['menu_controller' => 'apagar-cargo', 'menu_metodo' => 'apagar-cargo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/cargo/verCargo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cargo não encontrado!</div>";
            $UrlDestino = URLADM . 'cargo/listarCargo';
            header("Location: $UrlDestino");
        }
    }

}
