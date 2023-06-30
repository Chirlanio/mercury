<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarVideo {

    private $DadosId;
    private $Resultado;
    private $DadosArq;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarVideo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verVideo();
        if ($this->DadosArq) {
            var_dump($this->DadosArq);
            $apagarVideo = new \App\adms\Models\helper\AdmsDelete();
            $apagarVideo->exeDelete("adms_ed_videos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarVideo->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/treinamento/' . $this->DadosId . '/' . $this->DadosArq[0]['image_thumb'], 'assets/imagens/treinamento/' . $this->DadosId);
                
                $apagarVid = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarVid->apagarArq('assets/videos/treinamento/' . $this->DadosId . '/' . $this->DadosArq[0]['nome_video'], 'assets/videos/treinamento/' . $this->DadosId);
                
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Treinamento</strong> e Arquivos apagados com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Os Arquivos não foram apagados!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Treinamento e arquivos não apagados!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function verVideo() {
        $verVideo = new \App\adms\Models\helper\AdmsRead();
        $verVideo->fullRead("SELECT * FROM adms_ed_videos WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArq = $verVideo->getResultado();
    }

}
