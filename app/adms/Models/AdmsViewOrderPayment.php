<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewOrderPayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewOrderPayment {

    private $Resultado;
    private $DadosId;

    /**
     * <b>View Order payment:</b> Receber o id da solicitação de ordem de pagamento para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function viewOrder($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT o.*, a.name area, cc.name costCenter, bs.brand, sp.fantasy_name, tp.name typePayment, bk.bank_name bank,
                tk.name type_key, mn.name manager, so.exibition_name
                FROM adms_order_payments o
                LEFT JOIN adms_areas a ON a.id = o.adms_area_id
                LEFT JOIN adms_cost_centers cc ON cc.id = o.adms_cost_center_id
                LEFT JOIN adms_brands_suppliers bs ON bs.id = o.adms_brand_id
                LEFT JOIN adms_suppliers sp ON sp.id = o.adms_supplier_id
                LEFT JOIN adms_type_payments tp ON tp.id = o.adms_type_payment_id
                LEFT JOIN adms_banks bk ON bk.id = o.bank_id
                LEFT JOIN adms_type_key_pixs tk ON tk.id = o.adms_type_key_pix_id
                LEFT JOIN adms_managers mn ON mn.id = o.manager_id
                LEFT JOIN adms_sits_order_payments so ON so.id = o.adms_sits_order_pay_id
                WHERE o.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewOrder->getResultado();
        return $this->Resultado;
    }

}