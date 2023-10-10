<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditBrand
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditBank {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewBank($DadosId) {

        $this->DadosId = (int) $DadosId;

        $viewBank = new \App\adms\Models\helper\AdmsRead();
        $viewBank->fullRead("SELECT b.id, b.bank_name, b.cod_bank, b.status_id FROM adms_banks b LEFT JOIN adms_sits st ON st.id = b.status_id WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewBank->getResultado();
        return $this->Resultado;
    }

    public function altBank(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditBank();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditBank() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBank = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBank->exeUpdate("adms_banks", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBank->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O cadastro não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
