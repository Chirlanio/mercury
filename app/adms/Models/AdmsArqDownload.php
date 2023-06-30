<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsArqDownload
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsArqDownload {

    private $Resultado;

    public function listarArq() {
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT a.id id_arq, a.nome, a.adms_art_id, a.slug FROM adms_up_down a
                WHERE a.status_id =:status_id ORDER BY a.id DESC
                LIMIT :limit', "status_id=1&limit=7");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

}
