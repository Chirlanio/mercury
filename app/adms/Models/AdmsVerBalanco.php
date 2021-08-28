<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerBalanco {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id do balanço para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verBalanco($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verBalanco = new \App\adms\Models\helper\AdmsRead();
        $verBalanco->fullRead("SELECT ba.*, lj.nome nome_loja, st.nome status, r.nome resp_aud, f.nome resp_loja
                FROM adms_aud_balancos ba
                INNER JOIN tb_lojas lj ON lj.id=ba.loja_id
                INNER JOIN tb_status st ON st.id=ba.status_id
                INNER JOIN tb_funcionarios f ON f.id=ba.resp_loja_id
                INNER JOIN adms_aud_resp r ON r.id=ba.resp_auditor_id
                WHERE ba.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBalanco->getResultado();
        return $this->Resultado;
    }

}
