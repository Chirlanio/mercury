<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarRemanejo {

    private $DadosId;
    private $Resultado;
    private $DadosRemanejo;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarRemanejo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verRemanejo();
        if ($this->DadosRemanejo) {
            $apagarRemanejo = new \App\adms\Models\helper\AdmsDelete();
            $apagarRemanejo->exeDelete("adms_remanejos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarRemanejo->getResult()) {
                $apagarArq = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarArq->apagarArq('assets/files/remanejo/' . $this->DadosId . '/' . $this->DadosRemanejo[0]['arquivo'], 'assets/files/remanejo/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success'>Remanejo apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Remanejo não foi apagado!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Remanejo não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

    public function verRemanejo() {
        $verRemanejo = new \App\adms\Models\helper\AdmsRead();
        $verRemanejo->fullRead("SELECT rem.arquivo FROM adms_remanejos rem
                WHERE rem.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosRemanejo = $verRemanejo->getResult();
    }

}
