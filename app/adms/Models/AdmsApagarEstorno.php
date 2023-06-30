<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarEstorno {

    private $DadosId;
    private $Resultado;
    private $DadosArq;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarEstorno($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verEstorno();
        if ($this->DadosArq) {
            $apagarEstorno = new \App\adms\Models\helper\AdmsDelete();
            $apagarEstorno->exeDelete("adms_estornos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarEstorno->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('assets/files/estorno/' . $this->DadosId . '/' . $this->DadosArq[0]['arquivo'], 'assets/files/estorno/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro e Arquivo apagados com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Arquivo não foi apagado!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Cadastro e o Arquivos não foram apagados!</div>";
            $this->Resultado = false;
        }
    }

    public function verEstorno() {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT * FROM adms_estornos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArq = $verUsuario->getResultado();
    }

}
