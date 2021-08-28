<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerDashboard {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id do dashboard para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verDashboard($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verDash = new \App\adms\Models\helper\AdmsRead();
        $verDash->fullRead("SELECT dash.*,
                lj.nome loja,
                sit.id sit, sit.nome nome_sit, sit.cor cor,
                a.nome area
                FROM tb_dashboards dash
                INNER JOIN tb_lojas lj ON lj.id=dash.loja_id
                INNER JOIN adms_sits_pgs sit ON sit.id=dash.status_id
                INNER JOIN tb_areas a ON a.id=dash.area_id
                WHERE dash.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verDash->getResultado();
        return $this->Resultado;
    }

}
