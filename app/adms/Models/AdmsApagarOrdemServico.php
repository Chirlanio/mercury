<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarOrdemServico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarOrdemServico {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarOrdemServico($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarOrdemServico = new \App\adms\Models\helper\AdmsDelete();
        $apagarOrdemServico->exeDelete("adms_qualidade_ordem_servico", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarOrdemServico->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem de serviço apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A ordem de serviço não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
