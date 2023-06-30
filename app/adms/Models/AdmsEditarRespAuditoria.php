<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarRespAuditoria {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verRespAuditoria($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verBairro = new \App\adms\Models\helper\AdmsRead();
        $verBairro->fullRead("SELECT b.*
                FROM adms_responsavel_auditoria b
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBairro->getResultado();
        return $this->Resultado;
    }

    public function altRespAuditoria(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditRespAuditoria();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditRespAuditoria() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltRespAuditoria = new \App\adms\Models\helper\AdmsUpdate();
        $upAltRespAuditoria->exeUpdate("adms_responsavel_auditoria", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltRespAuditoria->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
