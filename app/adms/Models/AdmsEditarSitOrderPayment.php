<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarSitOrderPayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarSitOrderPayment {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verSit($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verSit = new \App\adms\Models\helper\AdmsRead();
        $verSit->fullRead("SELECT * FROM adms_sits_order_payments
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
        $upAltSit->exeUpdate("adms_sits_order_payments", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSit->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Situação</strong> atualizada com sucesso. Upload da imagem realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A situação não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_cors" para utilizar como chave estrangeira
     */
    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id, nome status FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
