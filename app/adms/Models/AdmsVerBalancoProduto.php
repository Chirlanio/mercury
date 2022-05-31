<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerBalancoProduto {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id do balanço para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verBalanco($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verBalanco = new \App\adms\Models\helper\AdmsRead();
        $verBalanco->fullRead("SELECT ba.*, s.nome status
                FROM adms_balanco_produtos ba
                INNER JOIN adms_sits_balanco_produto s ON s.id=ba.status_id
                WHERE ba.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBalanco->getResultado();
        return $this->Resultado;
    }

}
