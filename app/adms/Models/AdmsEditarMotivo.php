<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarMotivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarMotivo {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verMotivo($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verMotivo = new \App\adms\Models\helper\AdmsRead();
        $verMotivo->fullRead("SELECT b.id, b.nome motivo
                FROM adms_motivo_estorno b
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verMotivo->getResultado();
        return $this->Resultado;
    }

    public function altMotivo(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditMotivo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditMotivo() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltMotivo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltMotivo->exeUpdate("adms_motivo_estorno", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltMotivo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Motivo de estorno atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Motivo de estorno não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
