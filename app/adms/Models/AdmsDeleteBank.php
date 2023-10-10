<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDeleteBank
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDeleteBank {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function deleteBank($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $delBrand = new \App\adms\Models\helper\AdmsDelete();
        $delBrand->exeDelete("adms_banks", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($delBrand->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> apagada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O cadastro não foi apagada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
