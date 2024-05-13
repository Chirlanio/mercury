<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewPolicieBlog
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewPolicieBlog {

    private $Resultado;
    private $Slug;

    public function viewPolicie($Slug) {

        $this->Slug = (string) $Slug;

        $viewPolicie = new \App\adms\Models\helper\AdmsRead();
        $viewPolicie->fullRead("SELECT pl.*
                FROM adms_policies pl
                WHERE pl.slug =:slug AND pl.adms_sit_id =:adms_sit_id LIMIT :limit", "slug=" . $this->Slug . "&adms_sit_id=1&limit=1");
        $this->Resultado = $viewPolicie->getResult();
        return $this->Resultado;
    }

}
