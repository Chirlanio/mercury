<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsArtProxAnt
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsArtProxAnt {

    private $Resultado;
    private $IdArtigo;

    public function artigoProximo($IdArtigo = null) {
        
        $this->IdArtigo = (int) $IdArtigo;
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT id FROM adms_artigos
                WHERE adms_sit_id =:adms_sit_id AND id >:id
                ORDER BY id ASC
                LIMIT :limit', "adms_sit_id=1&id={$this->IdArtigo}&limit=1");

        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function artigoAnterior($IdArtigo = null) {
        
        $this->IdArtigo = (int) $IdArtigo;
        
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead('SELECT id FROM adms_artigos
                WHERE adms_sit_id =:adms_sit_id AND id <:id
                ORDER BY id DESC
                LIMIT :limit', "adms_sit_id=1&id={$this->IdArtigo}&limit=1");

        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

}
