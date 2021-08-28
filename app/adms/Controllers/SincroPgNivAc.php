<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SincroPgNivAc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SincroPgNivAc
{

    public function sincroPgNivAc()
    {
        $sincroPgNivAc = new \App\adms\Models\AdmsSincroPgNivAc();
        $sincroPgNivAc->sincroPgNivAc();
        $UrlDestino = URLADM . "nivel-acesso/listar";
        header("Location: $UrlDestino");
    }

}
