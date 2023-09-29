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
class AdmsEditBrand {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewBrand($DadosId) {

        $this->DadosId = (int) $DadosId;

        $viewSupplier = new \App\adms\Models\helper\AdmsRead();
        $viewSupplier->fullRead("SELECT b.id, b.brand, b.adms_supplier_id, s.fantasy_name, b.status_id
                FROM adms_brands_suppliers b
                LEFT JOIN adms_suppliers s ON s.id = b.adms_supplier_id
                LEFT JOIN adms_sits st ON st.id = b.status_id
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewSupplier->getResultado();
        return $this->Resultado;
    }

    public function altBrand(array $Dados) {
        $this->Dados = $Dados;
        var_dump($this->Dados);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditBrand();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditBrand() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBrand = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBrand->exeUpdate("adms_brands_suppliers", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBrand->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Marca</strong> atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A marca não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id su_id, fantasy_name supplier FROM adms_suppliers ORDER BY id ASC");
        $registro['supp'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit'], 'supp' => $registro['supp']];

        return $this->Resultado;
    }

}
