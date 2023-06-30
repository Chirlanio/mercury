<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVisuFaq
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVisuFaq {

    private $Resultado;
    private $Slug;

    public function verFaq($Slug) {

        $this->Slug = (string) $Slug;

        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT a.*, up.id id_arq, up.nome nome_arq, up.slug link FROM adms_artigos a LEFT JOIN adms_up_down up ON up.adms_art_id=a.id WHERE a.slug =:slug AND a.adms_sit_id =:adms_sit_id AND adms_cats_artigo_id =:adms_cats_artigo_id LIMIT :limit", "slug=" . $this->Slug . "&adms_sit_id=1&adms_cats_artigo_id=5&limit=1");
        $this->Resultado = $verArtigo->getResultado();
        return $this->Resultado;
    }

}
