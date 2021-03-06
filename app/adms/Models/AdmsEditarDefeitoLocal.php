<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarDefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarDefeitoLocal {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verDefeitoLocal($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verDefeitos = new \App\adms\Models\helper\AdmsRead();
        $verDefeitos->fullRead("SELECT d.id, d.descricao, d.status_id
                FROM adms_def_local_ordem_servico d
                WHERE d.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verDefeitos->getResultado();
        return $this->Resultado;
    }

    public function altDefeitoLocal(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditDefeitoLocal();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditDefeitoLocal() {

        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltDefeitos = new \App\adms\Models\helper\AdmsUpdate();
        $upAltDefeitos->exeUpdate("adms_def_local_ordem_servico", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);

        if ($upAltDefeitos->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id s_id, nome sit FROM adms_sits ORDER BY nome ASC");

        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
