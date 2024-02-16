<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewPersonnelMoviments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewPersonnelMoviments {

    private $Dados;
    private $DadosId;

    public function viewMoviment($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {

            $viewMoviment = new \App\adms\Models\AdmsViewPersonnelMoviments();
            $this->Dados['dados_moviment'] = $viewMoviment->viewMoviment($this->DadosId);

            $botao = ['list_moviment' => ['menu_controller' => 'personnel-moviments', 'menu_metodo' => 'list'],
                'edit_moviment' => ['menu_controller' => 'edit-personnel-moviments', 'menu_metodo' => 'edit-moviment'],
                'del_moviment' => ['menu_controller' => 'delete-personnel-moviments', 'menu_metodo' => 'delete-moviment']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/personnelMoviment/viewPersonnelMoviment", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'personnel-moviments/list';
            header("Location: $UrlDestino");
        }
    }
}
