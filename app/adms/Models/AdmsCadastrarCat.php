<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarCat
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarCat {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadCat(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirCat();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirCat() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadCat = new \App\adms\Models\helper\AdmsCreate;
        $cadCat->exeCreate("adms_cats_artigos", $this->Dados);

        if ($cadCat->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O categoria não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

}
