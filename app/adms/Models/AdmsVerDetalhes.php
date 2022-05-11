<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerDetalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerDetalhes {

    private $Resultado;
    private $DadosId;

    public function verDetalhes($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verDetalhes = new \App\adms\Models\helper\AdmsRead();
        $verDetalhes->fullRead("SELECT d.id , d.descricao, d.status_id, d.created, d.modified, s.nome sit
                FROM adms_detalhes_ordem_servico d
                INNER JOIN adms_sits s ON s.id=d.status_id
                WHERE d.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verDetalhes->getResultado();
        return $this->Resultado;
    }

}
