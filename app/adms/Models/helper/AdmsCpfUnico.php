<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of admsCpfUnico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCpfUnico {

    private $Cpf;
    private $Resultado;
    private $EditarUnico;
    private $DadoId;

    function getResultado() {
        return $this->Resultado;
    }

    public function valCpfUnico($Cpf, $EditarUnico = null, $DadoId = null) {
        $this->Cpf = (string) $Cpf;
        $this->EditarUnico = $EditarUnico;
        $this->DadoId = $DadoId;
        $valCpfUnico = new \App\adms\Models\helper\AdmsRead();
        if (!empty($this->EditarUnico) AND ($this->EditarUnico == true)) {
            $valCpfUnico->fullRead("SELECT id FROM adms_users_treinamentos WHERE cpf =:cpf AND id <>:id LIMIT :limit", "cpf={$this->Cpf}&limit=1&id={$this->DadoId}");
        } else {
            $valCpfUnico->fullRead("SELECT id FROM adms_users_treinamentos WHERE cpf =:cpf LIMIT :limit", "cpf={$this->Cpf}&limit=1");
        }
        $this->Resultado = $valCpfUnico->getResult();
        if (!empty($this->Resultado)) {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Este CPF já está cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }
}
