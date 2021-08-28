<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarCat
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarCat {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verCat($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verCat = new \App\adms\Models\helper\AdmsRead();
        $verCat->fullRead("SELECT * 
                FROM adms_cats_artigos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCat->getResultado();
        return $this->Resultado;
    }

    public function altCat(array $Dados) {
        
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCat();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCat() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCat = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCat->exeUpdate("adms_cats_artigos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCat->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de artigo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de artigo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
