<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerTipoPagamento {

    private $Resultado;
    private $DadosId;

    public function verTipo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verTipo = new \App\adms\Models\helper\AdmsRead();
        $verTipo->fullRead("SELECT b.id, b.nome, b.created, b.modified
                FROM tb_forma_pag b
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verTipo->getResultado();
        return $this->Resultado;
    }

}
