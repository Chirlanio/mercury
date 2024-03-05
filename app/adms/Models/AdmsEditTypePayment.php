<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditTypePayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditTypePayment {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewType($DadosId) {

        $this->DadosId = (int) $DadosId;

        $viewType = new \App\adms\Models\helper\AdmsRead();
        $viewType->fullRead("SELECT tp.id, tp.name, tp.status_id 
                FROM adms_type_payments tp
                WHERE tp.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewType->getResult();
        return $this->Resultado;
    }

    public function altType(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTypePayment();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTypePayment() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTipo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltTipo->exeUpdate("adms_type_payments", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTipo->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Tipo de pagamento</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Tipo de pagameto não atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }
    
    public function listAdd() {
        $list = new \App\adms\Models\helper\AdmsRead();
        
        $list->fullRead("SELECT id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $list->getResult();
        
        $this->Resultado = ['sits' => $registro['sits']];
        
        return $this->Resultado;
    }

}
