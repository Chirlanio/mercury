<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsArtDestaque
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsArtDestaque {

    private $Resultado;

    public function listarArtDestaque() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT a.id id_des, a.titulo, a.slug FROM adms_artigos a
                WHERE a.adms_sit_id =:adms_sit_id AND a.destaque =:destaque
                LIMIT :limit', "adms_sit_id=1&destaque=1&limit=7");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

}
