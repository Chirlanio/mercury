<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarArq
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarArq {

    private $NomeArq;
    private $Diretorio;

    public function apagarArq($NomeArq, $Diretorio = null) {
        $this->NomeArq = (string) $NomeArq;
        $this->Diretorio = (string) $Diretorio;
        $this->excluirArq();
        if (!empty($this->Diretorio)) {
            $this->excluirDiretorio();
        }
    }

    private function excluirArq() {
        if (file_exists($this->NomeArq)) {
            unlink($this->NomeArq);
        }
    }

    private function excluirDiretorio() {
        if (file_exists($this->Diretorio)) {
            rmdir($this->Diretorio);
        }
    }

}
