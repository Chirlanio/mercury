<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVisuArtigo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVisuArtigo {

    private $Resultado;
    private $Slug;

    public function verArtigo($Slug) {

        $this->Slug = (string) $Slug;

        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT a.*, up.id id_arq, up.nome nome_arq, up.slug link FROM adms_artigos a LEFT JOIN adms_up_down up ON up.id=a.adms_art_id WHERE a.slug =:slug AND a.adms_sit_id =:adms_sit_id LIMIT :limit", "slug=" . $this->Slug . "&adms_sit_id=1&limit=1");
        $this->Resultado = $verArtigo->getResult();
        return $this->Resultado;
    }

}
