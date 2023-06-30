<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerArtigo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerArtigo {

    private $Resultado;
    private $DadosId;

    public function verArtigo($DadosId) {
        
        $this->DadosId = (int) $DadosId;
        
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT art.*,
                sit.nome nome_sit,
                cr.cor cor_cr,
                tpart.nome nome_tpart,
                catart.nome nome_catart
                FROM adms_artigos art
                INNER JOIN adms_sits sit ON sit.id=art.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                INNER JOIN adms_tps_artigos tpart ON tpart.id=art.adms_tps_artigo_id
                INNER JOIN adms_cats_artigos catart ON catart.id=art.adms_cats_artigo_id
                WHERE art.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verArtigo->getResultado();
        return $this->Resultado;
    }

}
