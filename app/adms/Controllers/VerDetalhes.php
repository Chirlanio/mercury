<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerDetalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerDetalhes {

    private $Dados;
    private $DadosId;

    public function verDetalhes($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verDetalhes = new \App\adms\Models\AdmsVerDetalhes();
            $this->Dados['dados_detalhes'] = $verDetalhes->verDetalhes($this->DadosId);

            $botao = ['list_detalhes' => ['menu_controller' => 'detalhes', 'menu_metodo' => 'listar'],
                'edit_detalhes' => ['menu_controller' => 'editar-detalhes', 'menu_metodo' => 'edit-detalhes'],
                'del_detalhes' => ['menu_controller' => 'apagar-detalhes', 'menu_metodo' => 'apagar-detalhes']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/detalhes/verDetalhes", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Detalhe não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'detalhes/listar';
            header("Location: $UrlDestino");
        }
    }

}
