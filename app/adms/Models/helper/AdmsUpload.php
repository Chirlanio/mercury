<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsUpload
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsUpload {

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
            case 'text/plain';
            case 'application/msword';
            case 'application/vnd.ms-excel';
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case 'application/vnd.ms-powerpoint';
            case 'text/csv';
            case 'application/pdf';
            case 'application/x-rar-compressed';
            case 'application/zip';
            case 'image/jpeg';
            case 'image/png';
                $this->Arquivo = true;
                break;
        endswitch;
        if ($this->Arquivo) {
            $this->valDiretorio();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A extensão do arquivo é inválida. Selecione um arquivo válido! Ex: .txt, .xlsx, .doc, .pdf.</div>";
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
