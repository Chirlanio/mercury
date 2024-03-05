<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEmailUnicoTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEmailUnicoTreinamento {

    private $Email;
    private $Resultado;
    private $EditarUnico;
    private $DadoId;

    function getResultado() {
        return $this->Resultado;
    }

    public function valEmailUnico($Email, $EditarUnico = null, $DadoId = null) {
        $this->Email = (string) $Email;
        $this->EditarUnico = $EditarUnico;
        $this->DadoId = $DadoId;
        $valEmailUnico = new \App\adms\Models\helper\AdmsRead();
        if (!empty($this->EditarUnico) AND ($this->EditarUnico == true)) {
            $valEmailUnico->fullRead("SELECT id FROM adms_user_treinamentos WHERE email =:email AND id <>:id LIMIT :limit", "email={$this->Email}&limit=1&id={$this->DadoId}");
        } else {
            $valEmailUnico->fullRead("SELECT id FROM adms_user_treinamentos WHERE email =:email LIMIT :limit", "email={$this->Email}&limit=1");
        }
        $this->Resultado = $valEmailUnico->getResult();
        if (!empty($this->Resultado)) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Este e-mail já está cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
