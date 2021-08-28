<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerTransf {

    private $Dados;
    private $DadosId;

    public function verTransf($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verTransf = new \App\adms\Models\AdmsVerTransf();
            $this->Dados['dados_transf'] = $verTransf->verTransf($this->DadosId);

            $botao = ['list_transf' => ['menu_controller' => 'transferencia', 'menu_metodo' => 'listar-transf'],
                'edit_transf' => ['menu_controller' => 'editar-transf', 'menu_metodo' => 'edit-transf'],
                'del_transf' => ['menu_controller' => 'apagar-transf', 'menu_metodo' => 'apagar-transf']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/transferencia/verTransf", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Transferência não encontrada!</div>";
            $UrlDestino = URLADM . 'transferencia/listarTransf';
            header("Location: $UrlDestino");
        }
    }

}
