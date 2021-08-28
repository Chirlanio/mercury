<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsArtRecente
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsArtRecente {

    private $Resultado;

    public function listarArtRecente() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT a.id id_rec, a.titulo, a.slug,
                DATEDIFF(CURRENT_DATE, dataInicial) AS dias
                FROM adms_artigos a 
                WHERE a.adms_sit_id =:adms_sit_id AND a.destaque =:destaque
                ORDER BY id DESC
                LIMIT :limit', "adms_sit_id=1&destaque=1&limit=7");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

}
