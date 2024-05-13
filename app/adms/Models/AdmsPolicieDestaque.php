<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsPolicieDestaque
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsPolicieDestaque {

    private $Resultado;

    public function listPolicieDestaque() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT pl.id id_des, pl.title, pl.slug FROM adms_policies pl WHERE pl.adms_sit_id =:adms_sit_id AND pl.destaque =:destaque LIMIT :limit', "adms_sit_id=1&destaque=1&limit=7");
        $this->Resultado = $listar->getResult();
        return $this->Resultado;
    }

}
