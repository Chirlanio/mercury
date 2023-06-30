<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerBalanco {

    private $Dados;
    private $DadosId;

    public function verBalanco($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verBalanco = new \App\adms\Models\AdmsVerBalanco();
            $this->Dados['dados_balanco'] = $verBalanco->verBalanco($this->DadosId);

            $botao = ['list_balanco' => ['menu_controller' => 'balanco', 'menu_metodo' => 'listar'],
                'vis_balanco' => ['menu_controller' => 'ver-balanco', 'menu_metodo' => 'ver-balanco'],
                'edit_balanco' => ['menu_controller' => 'editar-balanco', 'menu_metodo' => 'edit-balanco'],
                'del_balanco' => ['menu_controller' => 'apagar-balanco', 'menu_metodo' => 'apagar-balanco']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/auditoria/verBalanco", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Balanço não encontrado!</div>";
            $UrlDestino = URLADM . 'balanco/listar';
            header("Location: $UrlDestino");
        }
    }

}
