<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsPolicieBlogRecente
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsPolicieBlogRecente {

    private $Resultado;

    public function listPolicieRecente() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT pl.id id_rec, pl.title, pl.slug, pl.created,
                DATEDIFF(CURRENT_DATE(), pl.dataInicial) AS dias
                FROM adms_policies pl 
                WHERE pl.adms_sit_id =:adms_sit_id
                ORDER BY pl.id DESC
                LIMIT :limit', "adms_sit_id=1&limit=7");
        $this->Resultado = $listar->getResult();
        return $this->Resultado;
    }

}
