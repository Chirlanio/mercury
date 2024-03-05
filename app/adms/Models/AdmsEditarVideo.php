<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarVideo {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $ImgAntiga;
    private $Video;
    private $VideoAntigo;
    private $Subtitulo;

    function getResultado() {
        return $this->Resultado;
    }

    public function verVideo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verVideo = new \App\adms\Models\helper\AdmsRead();
        $verVideo->fullRead("SELECT id, titulo, subtitulo, tema, facilitador, nome_video, image_thumb, description, status_id FROM adms_ed_videos WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verVideo->getResult();
        return $this->Resultado;
    }

    public function altVideo(array $Dados) {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        $this->Video = $this->Dados['video_novo'];
        $this->VideoAntigo = $this->Dados['video_antigo'];
        $this->Subtitulo = $this->Dados['subtitulo'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga'], $this->Dados['video_novo'], $this->Dados['video_antigo'], $this->Dados['subtitulo']);
        //var_dump($this->Dados);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);
        //var_dump($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valFoto();
        } else {
            $this->Resultado = false;
        }
    }

    private function valFoto() {
        if (empty($this->Foto['name']) or empty($this->Video['name'])) {
            $this->updateEditVideo();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['image_thumb'] = $slugImg->nomeSlug($this->Foto['name']);
            
            $slugVideo = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['nome_video'] = $slugVideo->nomeSlug($this->Video['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/treinamento/' . $this->Dados['id'] . '/', $this->Dados['image_thumb'], 640, 380);
            
            $uploadVideo = new \App\adms\Models\helper\AdmsUploadVideo();
            $uploadVideo->upload($this->Video, 'assets/videos/treinamento/'. $this->Dados['id'] .'/', $this->Dados['nome_video']);
            
            if ($uploadImg->getResultado() and $uploadVideo->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/treinamento/' . $this->Dados['id'] . '/' . $this->ImgAntiga);
                
                $apagarVideo = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarVideo->apagarArq('assets/videos/treinamento/' . $this->Dados['id'] . '/'. $this->VideoAntigo);
                
                $this->updateEditVideo();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditVideo() {
        $this->Dados['subtitulo'] = $this->Subtitulo;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSenha->exeUpdate("adms_ed_videos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSenha->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Treinamento</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> O treinamento não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        
        $listar->fullRead("SELECT id sit_id, nome status FROM tb_status ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResult();

        $this->Resultado = ['sit_id' => $registro['sit_id']];

        return $this->Resultado;
    }

}
