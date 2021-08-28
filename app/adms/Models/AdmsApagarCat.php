<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarCat
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarCat {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarCat($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        $apagarTipo = new \App\adms\Models\helper\AdmsDelete();
        $apagarTipo->exeDelete("adms_cats_artigos", "WHERE id =:id", "id={$this->DadosId}");

        if ($apagarTipo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A categoria não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
