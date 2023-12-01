<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewOrderPayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewProcessLibrary {

    private $Dados;
    private $DadosId;

    public function processLibrary($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {

            $viewOrder = new \App\adms\Models\AdmsViewProcessLibrary();
            $this->Dados['dados_process'] = $viewOrder->viewProcess($this->DadosId);

            $botao = ['list_process' => ['menu_controller' => 'process-library', 'menu_metodo' => 'list'],
                'edit_process' => ['menu_controller' => 'edit-process-library', 'menu_metodo' => 'process-library'],
                'del_process' => ['menu_controller' => 'delete-process-library', 'menu_metodo' => 'process-library']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/biblioteca/viewProcessLibrary", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'process-library/list';
            header("Location: $UrlDestino");
        }
    }
}
