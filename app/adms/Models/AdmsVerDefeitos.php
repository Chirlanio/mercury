<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerBandeira {

    private $Resultado;
    private $DadosId;

    public function verBandeira($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verBandeira = new \App\adms\Models\helper\AdmsRead();
        $verBandeira->fullRead("SELECT b.id id_ban, b.nome bandeira, b.icone, b.created, b.modified
                FROM adms_bandeiras b
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBandeira->getResultado();
        return $this->Resultado;
    }

}
