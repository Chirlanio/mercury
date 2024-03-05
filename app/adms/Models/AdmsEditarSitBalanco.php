<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarSitBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarSitBalanco {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verSit($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verSit = new \App\adms\Models\helper\AdmsRead();
        $verSit->fullRead("SELECT * FROM adms_status_balancos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSit->getResult();
        return $this->Resultado;
    }

    public function altSit(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditSit();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSit() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSit = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSit->exeUpdate("adms_status_balancos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSit->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
