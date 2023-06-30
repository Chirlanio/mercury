<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerBairro {

    private $Dados;
    private $DadosId;

    public function verBairro($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verBairro = new \App\adms\Models\AdmsVerBairro();
            $this->Dados['dados_bairro'] = $verBairro->verBairro($this->DadosId);

            $botao = ['list_bairro' => ['menu_controller' => 'bairro', 'menu_metodo' => 'listar'],
                'edit_bairro' => ['menu_controller' => 'editar-bairro', 'menu_metodo' => 'edit-bairro'],
                'del_bairro' => ['menu_controller' => 'apagar-bairro', 'menu_metodo' => 'apagar-bairro']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/bairro/verBairro", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Bairro não encontrado!</div>";
            $UrlDestino = URLADM . 'bairro/listar';
            header("Location: $UrlDestino");
        }
    }

}
