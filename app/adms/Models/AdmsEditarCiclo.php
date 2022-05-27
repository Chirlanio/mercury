<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarCiclo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarCiclo {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verCiclo($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verCiclo = new \App\adms\Models\helper\AdmsRead();
        $verCiclo->fullRead("SELECT c.* 
                FROM adms_ciclos c
                WHERE c.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCiclo->getResultado();
        return $this->Resultado;
    }

    public function altCiclo(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCiclo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCiclo() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCiclo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCiclo->exeUpdate("adms_ciclos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCiclo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, nome sit FROM adms_sits ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
