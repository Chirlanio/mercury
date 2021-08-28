<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarDashboard {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadDash(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirDash();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirDash() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadDash = new \App\adms\Models\helper\AdmsCreate;
        $cadDash->exeCreate("tb_dashboards", $this->Dados);
        if ($cadDash->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Dashboard cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O dashboard não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id loja_id, nome loja_nome FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_niv, nome nivac FROM adms_niveis_acessos WHERE ordem >=:ordem ORDER BY nome ASC", "ordem=" . $_SESSION['ordem_nivac']);
        $registro['niv_ac'] = $listar->getResultado();

        $listar->fullRead("SELECT id area_id, nome area FROM tb_areas ORDER BY nome ASC");
        $registro['area'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'niv_ac' => $registro['niv_ac'], 'area' => $registro['area']];

        return $this->Resultado;
    }

}
