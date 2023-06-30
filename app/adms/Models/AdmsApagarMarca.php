<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarMarca {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarMarca($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarMarca = new \App\adms\Models\helper\AdmsDelete();
        $apagarMarca->exeDelete("adms_marcas", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarMarca->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Marca apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A marca não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
