<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewTypePayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewTypePayment {

    private $Resultado;
    private $DadosId;

    public function viewType($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewType = new \App\adms\Models\helper\AdmsRead();
        $viewType->fullRead("SELECT tp.id, tp.name, s.nome status, tp.created, tp.modified
                FROM adms_type_payments tp
                LEFT JOIN adms_sits s ON s.id=tp.status_id
                WHERE tp.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewType->getResultado();
        return $this->Resultado;
    }

}
