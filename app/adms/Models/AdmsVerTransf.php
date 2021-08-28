<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerTransf {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id do dashboard para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verTransf($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verTransf = new \App\adms\Models\helper\AdmsRead();
        $verTransf->fullRead("SELECT t.*,
                l.nome loja_ori, lj.nome loja_des,
                tt.nome tipo, s.nome sit
                FROM tb_transferencias t
                INNER JOIN tb_lojas l ON l.id=t.loja_origem_id
                INNER JOIN tb_lojas lj ON lj.id=t.loja_destino_id
                INNER JOIN tb_tipo_transf tt ON tt.id=t.tipo_transf_id
                INNER JOIN tb_status_transf s ON s.id=t.status_id
                WHERE t.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verTransf->getResultado();
        return $this->Resultado;
    }

}
