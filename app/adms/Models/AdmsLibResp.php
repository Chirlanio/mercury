<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsLibResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsLibResp {

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosResp;

    function getResultado() {
        return $this->Resultado;
    }

    public function libResp($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verResp();
        if ($this->DadosResp) {
            $this->altResp();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterada a solicitação!</div>";
            $this->Resultado = false;
        }
    }

    private function verResp() {
        $verResp = new \App\adms\Models\helper\AdmsRead();
        $verResp->fullRead("SELECT resp.id, resp.adms_sits_est_id 
                FROM adms_estornos resp
                WHERE resp.id =:id", "id={$this->DadosId}");
        $this->DadosResp = $verResp->getResultado();
    }

    private function altResp() {
        if ($this->DadosResp[0]['adms_sits_est_id'] == 2) {
            $this->Dados['adms_sits_est_id'] = 3;
        } else {
            $this->Dados['adms_sits_est_id'] = 2;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upPerm = new \App\adms\Models\helper\AdmsUpdate();
        $upPerm->exeUpdate("adms_estornos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upPerm->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Estorno autorizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi autorizado o estorno!</div>";
            $this->Resultado = false;
        }
    }

}
