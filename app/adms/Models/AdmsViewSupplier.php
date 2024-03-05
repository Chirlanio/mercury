<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewSuppleir
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewSupplier {

    private $Resultado;
    private $DadosId;

    public function viewSupplier($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewSupplier = new \App\adms\Models\helper\AdmsRead();
        $viewSupplier->fullRead("SELECT s.id id_supp, s.corporate_social, s.fantasy_name, s.cnpj_cpf, s.contact, s.email, s.status_id status, s.created, s.modified FROM adms_suppliers s INNER JOIN adms_sits st ON st.id=s.status_id WHERE s.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewSupplier->getResult();
        return $this->Resultado;
    }

}
