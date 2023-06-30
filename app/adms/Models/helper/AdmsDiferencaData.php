<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDiferencaData
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class AdmsDiferencaData {

    private $Dados;
    private $DataEmissao;
    private $DataConfirmacao;
    private $Dias;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function validarDados(array $Dados) {

        $this->Dados = $Dados;

        $this->DataEmissao = new \DateTime($this->Dados['created']);
        $this->DataConfirmacao = new \DateTime($this->Dados['modified']);

        if (!empty($this->Dados['modified'])) {
            $this->Dias = $this->DataEmissao->diff($this->DataConfirmacao)->days;
        } else {
            $this->Dias = $this->DataEmissao->diff(date('Y-m-d'))->days;
        }
        $this->Resultado = $this->Dias;
    }

}
