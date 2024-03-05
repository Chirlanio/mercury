<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarResp {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verResp($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verResp = new \App\adms\Models\helper\AdmsRead();
        $verResp->fullRead("SELECT * FROM adms_resp_autorizacao
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verResp->getResult();
        return $this->Resultado;
    }

    public function altResp(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditResp();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditResp() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltResp = new \App\adms\Models\helper\AdmsUpdate();
        $upAltResp->exeUpdate("adms_resp_autorizacao", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltResp->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        
        $listar->fullRead("SELECT id id_resp, nome resp
                from adms_usuarios
                WHERE adms_sits_usuario_id =:adms_sits_usuario_id ORDER BY nome ASC", "adms_sits_usuario_id=1");
        $registro['resp'] = $listar->getResult();
        
        $this->Resultado = ['resp' => $registro['resp']];
        
        return $this->Resultado;
    }

}
