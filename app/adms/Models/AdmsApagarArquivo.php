<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarArquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarArquivo {

    private $DadosId;
    private $Resultado;
    private $DadosArq;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarArquivo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verArquivo();
        if ($this->DadosArq) {
            $apagarArq = new \App\adms\Models\helper\AdmsDelete();
            $apagarArq->exeDelete("adms_up_down", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarArq->getResult()) {
                $apagar = new \App\adms\Models\helper\AdmsApagarArq();
                $apagar->apagarArq('assets/files/downloads/' . $this->DadosId . '/' . $this->DadosArq[0]['slug'], 'assets/files/downloads/' . $this->DadosId);
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

    public function verArquivo() {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT * FROM adms_up_down
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArq = $verUsuario->getResult();
    }

}
