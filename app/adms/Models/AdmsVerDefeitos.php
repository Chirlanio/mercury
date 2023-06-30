<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerDefeitos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerDefeitos {

    private $Resultado;
    private $DadosId;

    public function verDefeitos($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verBandeira = new \App\adms\Models\helper\AdmsRead();
        $verBandeira->fullRead("SELECT d.id , d.descricao, d.status_id, d.created, d.modified, s.nome sit
                FROM adms_defeitos_ordem_servico d
                INNER JOIN adms_sits s ON s.id=d.status_id
                WHERE d.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBandeira->getResultado();
        return $this->Resultado;
    }

}
