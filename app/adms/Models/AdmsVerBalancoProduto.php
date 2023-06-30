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
    private $BalancoId;

    /**
     * <b>Ver Página:</b> Receber o id do balanço para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verBalanco($DadosId, $BalancoId = null) {
        $this->DadosId = (int) $DadosId;
        $this->BalancoId = (int) $BalancoId;

        $verBalanco = new \App\adms\Models\helper\AdmsRead();
        $verBalanco->fullRead("SELECT ba.*, t.nome tam, sp.nome situacao, st.nome status
                FROM adms_balanco_produtos ba
                INNER JOIN tb_tam t ON t.id = ba.tam_id
                INNER JOIN adms_sits_balanco_produto sp ON sp.id = ba.situacao
                INNER JOIN adms_status_balancos st ON st.id = ba.status_id
                WHERE ba.id =:id AND ba.balanco_id =:balanco_id LIMIT :limit", "id={$this->DadosId}&balanco_id={$this->BalancoId}&limit=1");
        $this->Resultado = $verBalanco->getResultado();
        return $this->Resultado;
    }

}
