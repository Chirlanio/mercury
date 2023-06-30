<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarCfop {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verCfop($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verCfop = new \App\adms\Models\helper\AdmsRead();
        $verCfop->fullRead("SELECT * FROM adms_cfops
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCfop->getResultado();
        return $this->Resultado;
    }

    public function altCfop(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCfop();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCfop() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCfop = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCfop->exeUpdate("adms_cfops", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCfop->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cfop atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cfop não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
