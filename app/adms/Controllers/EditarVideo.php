<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarVideo {

    private $Dados;
    private $DadosId;

    public function editVideo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editVideoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Treinamento não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>!</div>";
            $UrlDestino = URLADM . 'escola-digital/listar-videos';
            header("Location: $UrlDestino");
        }
    }

    private function editVideoPriv() {
        if (!empty($this->Dados['EditVideo'])) {
            unset($this->Dados['EditVideo']);

            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $this->Dados['video_novo'] = ($_FILES['video_novo'] ? $_FILES['video_novo'] : null);

            $editarVideo = new \App\adms\Models\AdmsEditarVideo();
            $editarVideo->altVideo($this->Dados);

            if ($editarVideo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Treinamento</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-video/ver-video/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editVideoViewPriv();
            }
        } else {
            $verVideo = new \App\adms\Models\AdmsEditarVideo();
            $this->Dados['form'] = $verVideo->verVideo($this->DadosId);
            $this->editVideoViewPriv();
        }
    }

    private function editVideoViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarVideo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_video' => ['menu_controller' => 'ver-video', 'menu_metodo' => 'ver-video']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/treinamento/editarVideo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Treinamento não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>!</div>";
            $UrlDestino = URLADM . 'escola-digital/listar-videos';
            header("Location: $UrlDestino");
        }
    }

}
