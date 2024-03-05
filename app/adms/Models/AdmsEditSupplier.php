<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditSupplier {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewSupplier($DadosId) {

        $this->DadosId = (int) $DadosId;

        $viewSupplier = new \App\adms\Models\helper\AdmsRead();
        $viewSupplier->fullRead("SELECT s.id id_supp, s.corporate_social, s.fantasy_name, s.cnpj_cpf, s.contact, s.email, s.status_id
                FROM adms_suppliers s
                INNER JOIN adms_sits st ON st.id=s.status_id
                WHERE s.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewSupplier->getResult();
        return $this->Resultado;
    }

    public function altSupplier(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditSupplier();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSupplier() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSupplier = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSupplier->exeUpdate("adms_suppliers", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSupplier->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Fornecedor</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O fornecedor não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
