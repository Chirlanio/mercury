<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarDetalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarDetalhes {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verDetalhes($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verDefeitos = new \App\adms\Models\helper\AdmsRead();
        $verDefeitos->fullRead("SELECT d.id, d.descricao, d.status_id FROM adms_detalhes_ordem_servico d WHERE d.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verDefeitos->getResult();
        return $this->Resultado;
    }

    public function altDetalhes(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditDetalhes();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditDetalhes() {

        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltDetalhes = new \App\adms\Models\helper\AdmsUpdate();
        $upAltDetalhes->exeUpdate("adms_detalhes_ordem_servico", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);

        if ($upAltDetalhes->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Detalhe não atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id s_id, nome sit FROM adms_sits ORDER BY nome ASC");

        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
