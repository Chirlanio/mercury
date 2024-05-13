<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDeletePolicie
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDeletePolicie {

    private $DadosId;
    private $Resultado;
    private $DadosPolicie;

    function getResultado() {
        return $this->Resultado;
    }

    public function delPolicie($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->viewPolicie();
        if ($this->DadosPolicie) {
            $delPolicie = new \App\adms\Models\helper\AdmsDelete();
            $delPolicie->exeDelete("adms_policies", "WHERE id =:id", "id={$this->DadosId}");
            if ($delPolicie->getResult()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/imagens/policies/' . $this->DadosId . '/' . $this->DadosPolicie[0]['image'], 'assets/imagens/policies/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Política</strong> apagada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A política não foi encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function viewPolicie() {
        $viewPolicie = new \App\adms\Models\helper\AdmsRead();
        $viewPolicie->fullRead("SELECT image FROM adms_policies WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosPolicie = $viewPolicie->getResult();
    }

}
