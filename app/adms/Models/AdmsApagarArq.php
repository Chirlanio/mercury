<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarArq {

    private $DadosId;
    private $Resultado;
    private $DadosArq;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarArq($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verArq();
        if ($this->DadosArq) {
            $apagarArq = new \App\adms\Models\helper\AdmsDelete();
            $apagarArq->exeDelete("adms_up_down", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarArq->getResult()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/download/' . $this->DadosId . '/' . $this->DadosArq[0]['slug'], 'assets/download/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro e Arquivo apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Arquivo não foi apagado!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Cadastro e o Arquivo não foram apagados!</div>";
            $this->Resultado = false;
        }
    }

    public function verArq() {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT * FROM adms_up_down
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArq = $verUsuario->getResult();
    }

}
