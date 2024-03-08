<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarVideo
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class CadastrarVideo {

    private $Dados;

    public function cadVideos() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadVideo'])) {
            unset($this->Dados['CadVideo']);
            $this->Dados['nome_video'] = ($_FILES['nome_video'] ? $_FILES['nome_video'] : null);
            $this->Dados['image_thumb'] = ($_FILES['image_thumb'] ? $_FILES['image_thumb'] : null);
            $cadVideo = new \App\adms\Models\AdmsCadastrarVideo();
            $cadVideo->cadVideo($this->Dados);
            
            if ($cadVideo->getResultado()) {
                $UrlDestino = URLADM . 'escola-digital/listar-videos';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadVideoViewPriv();
            }
        } else {
            $this->cadVideoViewPriv();
        }
    }

    private function cadVideoViewPriv() {

        $botao = ['list_video' => ['menu_controller' => 'escola-digital', 'menu_metodo' => 'listar-videos'],
            'cad_video' => ['menu_controller' => 'cadastrar-video', 'menu_metodo' => 'cad-videos'],
            'ver_video' => ['menu_controller' => 'ver-video', 'menu_metodo' => 'ver-video'],
            'editar_video' => ['menu_controller' => 'editar-video', 'menu_metodo' => 'edit-video'],
            'del_video' => ['menu_controller' => 'apagar-video', 'menu_metodo' => 'apagar-video']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/treinamento/cadVideo", $this->Dados);
        $carregarView->renderizar();
    }

}
