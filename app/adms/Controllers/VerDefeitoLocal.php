<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerDefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerDefeitoLocal {

    private $Dados;
    private $DadosId;

    public function verDefeitoLocal($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verDefeito = new \App\adms\Models\AdmsVerDefeitoLocal();
            $this->Dados['dados_def_local'] = $verDefeito->verDefeitoLocal($this->DadosId);

            $botao = ['list_def_local' => ['menu_controller' => 'defeito-local', 'menu_metodo' => 'listar'],
                'edit_def_local' => ['menu_controller' => 'editar-defeito-local', 'menu_metodo' => 'edit-defeito-local'],
                'del_def_local' => ['menu_controller' => 'apagar-defeito-local', 'menu_metodo' => 'apagar-defeito-local']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/defeitoLocal/verDefLocal", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'defeito-local/listar';
            header("Location: $UrlDestino");
        }
    }

}
