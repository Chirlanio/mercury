<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EscolaDigitalVideos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EscolaDigital {

    private $Dados;
    private $PageId;

    public function listarVideos($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_video' => ['menu_controller' => 'cadastrar-video', 'menu_metodo' => 'cad-videos'],
            'vis_video' => ['menu_controller' => 'ver-video', 'menu_metodo' => 'ver-video'],
            'edit_video' => ['menu_controller' => 'editar-video', 'menu_metodo' => 'edit-video'],
            'del_video' => ['menu_controller' => 'apagar-video', 'menu_metodo' => 'apagar-video']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarVideos = new \App\adms\Models\AdmsListarVideos();
        $this->Dados['listVideos'] = $listarVideos->listarVideos($this->PageId);
        $this->Dados['paginacao'] = $listarVideos->getResultado();

        $carregarView = new \Core\ConfigView("adms/Views/treinamento/listarVideos", $this->Dados);
        $carregarView->renderizar();
    }

}
