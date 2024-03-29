<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerPagina
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerPagina {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verPagina($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPagina = new \App\adms\Models\helper\AdmsRead();
        $verPagina->fullRead("SELECT pg.*, grpg.nome nome_grpg, tpgs.tipo tipo_tpgs, tpgs.nome nome_tpgs, sitpg.nome nome_sitpg, sitpg.cor cor_sitpg FROM adms_paginas pg INNER JOIN adms_grps_pgs grpg ON grpg.id=pg.adms_grps_pg_id INNER JOIN adms_tps_pgs tpgs ON tpgs.id=pg.adms_tps_pg_id INNER JOIN adms_sits_pgs sitpg ON sitpg.id=pg.adms_sits_pg_id WHERE pg.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verPagina->getResult();
        return $this->Resultado;
    }

}
