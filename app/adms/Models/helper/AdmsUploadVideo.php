<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsUploadVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsUploadVideo {

    private $DadosArq;
    private $Diretorio;
    private $NomeArq;
    private $Arquivo;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function upload(array $Arquivo, $Diretorio, $NomeArq) {
        $this->DadosArq = $Arquivo;
        $this->Diretorio = $Diretorio;
        $this->NomeArq = $NomeArq;
        $this->Arquivo = false;
        $this->validarArq();
    }

    private function validarArq() {
        switch ($this->DadosArq['type']):
            case 'video/mp4';
            case 'video/ogg';
            case 'video/webm';
                $this->Arquivo = true;
                break;
        endswitch;
        if ($this->Arquivo) {
            $this->valDiretorio();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A extensão do vídeo é inválida. Selecione um arquivo válido! Ex: .mp4, .ogg, .WebM.</div>";
            $this->Resultado = false;
        }
    }

    private function valDiretorio() {
        if (!file_exists($this->Diretorio) && !is_dir($this->Diretorio)) {
            mkdir($this->Diretorio, 0755);
        }
        $this->realizarUpload();
    }

    private function realizarUpload() {
        if (move_uploaded_file($this->DadosArq['tmp_name'], $this->Diretorio . $this->NomeArq)) {
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível realizar o upload do arquivo!</div>";
            $this->Resultado = false;
        }
    }

}
