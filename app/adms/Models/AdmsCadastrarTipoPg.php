<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarTipoPg
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarTipoPg {

    private $Resultado;
    private $Dados;
    private $UltimoTipoPg;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadTipoPg(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirTipoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirTipoPg() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimoTipoPg();
        $this->Dados['ordem'] = $this->UltimoTipoPg[0]['ordem'] + 1;
        $cadTipoPg = new \App\adms\Models\helper\AdmsCreate;
        $cadTipoPg->exeCreate("adms_tps_pgs", $this->Dados);
        if ($cadTipoPg->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de página cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    private function verUltimoTipoPg() {
        $verTipoPg = new \App\adms\Models\helper\AdmsRead();
        $verTipoPg->fullRead("SELECT ordem FROM adms_tps_pgs ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoTipoPg = $verTipoPg->getResult();
    }

}
