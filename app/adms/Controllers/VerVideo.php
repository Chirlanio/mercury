<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerVideo {

    private $Dados;
    private $DadosId;

    public function verVideo($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            
            $verVideo = new \App\adms\Models\AdmsVerVideo();
            $this->Dados['dados_video'] = $verVideo->verVideo($this->DadosId);

            $botao = ['list_video' => ['menu_controller' => 'escola-digital', 'menu_metodo' => 'listar-videos'],
                'edit_video' => ['menu_controller' => 'editar-video', 'menu_metodo' => 'edit-video'],
                'del_video' => ['menu_controller' => 'apagar-video', 'menu_metodo' => 'apagar-video']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/treinamento/verVideo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Treinamento não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'escola-digital/listar-videos';
            header("Location: $UrlDestino");
        }
    }

}
