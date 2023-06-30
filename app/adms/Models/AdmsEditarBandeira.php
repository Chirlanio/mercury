<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarBandeira {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verBandeira($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verBandeira = new \App\adms\Models\helper\AdmsRead();
        $verBandeira->fullRead("SELECT b.id id_ban, b.nome bandeira, b.icone
                FROM adms_bandeiras b
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBandeira->getResultado();
        return $this->Resultado;
    }

    public function altBandeira(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditBandeira();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditBandeira() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBandeira = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBandeira->exeUpdate("adms_bandeiras", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBandeira->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Bandeira atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A bandeira não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

}
