<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarTipoArt
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarTipoArt {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verTipo($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verTipo = new \App\adms\Models\helper\AdmsRead();
        $verTipo->fullRead("SELECT * 
                FROM adms_tps_artigos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verTipo->getResultado();
        return $this->Resultado;
    }

    public function altTipo(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTipo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTipo() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBairro = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBairro->exeUpdate("adms_tps_artigos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBairro->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de artigo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de artigo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
