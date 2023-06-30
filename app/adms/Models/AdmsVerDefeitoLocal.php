<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerDefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerDefeitoLocal {

    private $Resultado;
    private $DadosId;

    public function verDefeitoLocal($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verDefeito = new \App\adms\Models\helper\AdmsRead();
        $verDefeito->fullRead("SELECT d.id , d.descricao, d.status_id, d.created, d.modified, s.nome sit
                FROM adms_def_local_ordem_servico d
                INNER JOIN adms_sits s ON s.id=d.status_id
                WHERE d.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verDefeito->getResultado();
        return $this->Resultado;
    }

}
