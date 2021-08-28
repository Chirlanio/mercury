<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarCargo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarCargo {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verCargo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verCargo = new \App\adms\Models\helper\AdmsRead();
        $verCargo->fullRead("SELECT * FROM tb_cargos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCargo->getResultado();
        return $this->Resultado;
    }

    public function altCargo(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCargo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCargo() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCargo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCargo->exeUpdate("tb_cargos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCargo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cargo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cargo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
