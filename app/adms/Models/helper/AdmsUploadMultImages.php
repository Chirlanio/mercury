<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsUploadMultImages
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsUploadMultImages {

    private $Diretorio;
    private $Resultado;
    private $Arquivos = [];
    private $TiposAceitos = [
        'image/jpeg',
        'image/png',
        'image/jpg'
    ];

    public function getResultado() {
        return $this->Resultado;
    }

    public function upload($Diretorio, $Arquivos) {
        $this->Diretorio = $Diretorio;
        $this->Arquivos = $Arquivos;
        $this->realizarUpload();
    }

    private function realizarUpload() {
        if (!file_exists($this->Diretorio) && !is_dir($this->Diretorio)) {
            mkdir($this->Diretorio, 0755, true);
        }

        foreach ($this->Arquivos as $arquivo) {
            $tipoArquivo = $arquivo['type'];

            if ((in_array($tipoArquivo, $this->TiposAceitos)) and (!empty($tipoArquivo))) {
                $this->validate();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A extensão do arquivo é inválida. Selecione um arquivo válido! Ex: .txt, .xlsx, .doc, .pdf.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        }
    }

    private function validate() {

        foreach ($this->Arquivos as $key => $Filename) {
            $nomeArquivoTemp = $this->Arquivos[$key]['tmp_name'];

            $Filename = new \App\adms\Models\helper\AdmsSlug();
            $nomeArquivo = $Filename->nomeSlug($this->Arquivos[$key]['name']);

            if ((move_uploaded_file($nomeArquivoTemp, $this->Diretorio . $nomeArquivo)) and (!empty($nomeArquivoTemp))) {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Não foi possível realizar o upload do arquivo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            } else {
                $this->Resultado = true;
            }
        }
    }
}
