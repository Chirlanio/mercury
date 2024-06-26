<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarSitTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarSitTransf {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verSit($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verSit = new \App\adms\Models\helper\AdmsRead();
        $verSit->fullRead("SELECT * FROM tb_status_transf
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
        $upAltSit->exeUpdate("tb_status_transf", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSit->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_cors" para utilizar como chave estrangeira
     */
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_cor, nome nome_cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor'] = $listar->getResult();

        $this->Resultado = ['cor' => $registro['cor']];

        return $this->Resultado;
    }

}
