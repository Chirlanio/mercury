<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarTipoRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarTipoRemanejo {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verTipoRemanejo($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verRemanejo = new \App\adms\Models\helper\AdmsRead();
        $verRemanejo->fullRead("SELECT b.id, b.nome 
                FROM adms_tps_remanejos b
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verRemanejo->getResultado();
        return $this->Resultado;
    }

    public function altTipoRemanejo(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTipoRemanejo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTipoRemanejo() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTipo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltTipo->exeUpdate("adms_tps_remanejos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTipo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de remanejo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de remanejo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
