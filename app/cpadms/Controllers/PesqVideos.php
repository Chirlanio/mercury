<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqVideos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqVideos {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null) {

        $botao = ['list_video' => ['menu_controller' => 'escola-digital', 'menu_metodo' => 'listar-videos'],
            'cad_video' => ['menu_controller' => 'cadastrar-video', 'menu_metodo' => 'cad-video'],
            'vis_video' => ['menu_controller' => 'ver-video', 'menu_metodo' => 'ver-video'],
            'edit_video' => ['menu_controller' => 'editar-video', 'menu_metodo' => 'edit-video'],
            'del_video' => ['menu_controller' => 'apagar-video', 'menu_metodo' => 'apagar-video']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqVideo'])) {
            unset($this->DadosForm['PesqVideo']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['titulo'] = filter_input(INPUT_GET, 'titulo', FILTER_DEFAULT);
        }

        $listarVideo = new \App\cpadms\Models\CpAdmsPesqVideo();
        $this->Dados['listVideo'] = $listarVideo->listarVideo($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarVideo->getResultadoPg();

        $carregarView = new \Core\ConfigView("cpadms/Views/treinamento/pesqVideos", $this->Dados);
        $carregarView->renderizar();
    }

}
