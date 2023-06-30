<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarVideo
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsCadastrarVideo {

    private $Resultado;
    private $Dados;
    private $Video;
    private $Image;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadVideo(array $Dados) {

        $this->Dados = $Dados;

        $this->Video = $this->Dados['nome_video'];
        $this->Image = $this->Dados['image_thumb'];
        unset($this->Dados['nome_video'], $this->Dados['image_thumb'], $this->Dados['subtitulo']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirEstorno();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirEstorno() {

        $this->Dados['status_id'] = 1;
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $slugEst = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['nome_video'] = $slugEst->nomeSlug($this->Video['name']);
        $this->Dados['image_thumb'] = $slugEst->nomeSlug($this->Image['name']);

        $cadVideo = new \App\adms\Models\helper\AdmsCreate;
        $cadVideo->exeCreate("adms_ed_videos", $this->Dados);
        
        if ($cadVideo->getResultado()) {
            if ((empty($this->Video['name'])) and (empty($this->Image['name']))) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Treinamento cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadVideo->getResultado();
                $this->valVideo();
                $this->valImage();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O treinamento não foi cadastrado!</div>";
            $this->Resultado = false;
        };
    }

    private function valVideo() {
        $uploadFile = new \App\adms\Models\helper\AdmsUploadVideo();
        $uploadFile->upload($this->Video, 'assets/videos/treinamento/' . $this->Dados['id'] . '/', $this->Dados['nome_video']);
        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação cadastrada com sucesso. Upload do arquivo realizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info'>Erro: Solicitação cadastrada. Erro ao realizar o upload do arquivo!</div>";
            $this->Resultado = false;
        }
    }

    private function valImage() {
        $uploadFile = new \App\adms\Models\helper\AdmsUpload();
        $uploadFile->upload($this->Image, 'assets/imagens/treinamento/' . $this->Dados['id'] . '/', $this->Dados['image_thumb']);
        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação cadastrada com sucesso. Upload do arquivo realizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info'>Erro: Solicitação cadastrada. Erro ao realizar o upload do arquivo!</div>";
            $this->Resultado = false;
        }
    }

}
