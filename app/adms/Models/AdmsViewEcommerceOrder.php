<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewEcommerceOrder
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewEcommerceOrder {

    private $Resultado;
    private $DadosId;

    /**
     * <b>View Ecommerce Order:</b> Receber o id da solicitação de pedido de faturamento para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function viewOrder($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT e.*, l.nome store, f.nome colaborador, s.name status, u.nome creator FROM adms_ecommerce_orders e LEFT JOIN tb_lojas l ON l.id = e.loja_id LEFT JOIN tb_funcionarios f ON f.id = e.func_id LEFT JOIN adms_sits_ecommerce s ON s.id = e.adms_sit_ecommerce_id LEFT JOIN adms_usuarios u ON u.id = e.created_by WHERE e.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewOrder->getResultado();
        return $this->Resultado;
    }
}
