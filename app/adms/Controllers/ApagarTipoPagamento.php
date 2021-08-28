<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarTipoPagamento {

    private $DadosId;

    public function apagarTipo($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $apagarTipo = new \App\adms\Models\AdmsApagarTipoPagamento();
            $apagarTipo->apagarTipo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um Tipo de Pagamento!</div>";
        }
        $UrlDestino = URLADM . 'tipo-pagamento/listar';
        header("Location: $UrlDestino");
    }

}
