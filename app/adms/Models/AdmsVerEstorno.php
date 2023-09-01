<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerEstorno {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Estorno:</b> Receber o id da solicitação de estorno para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verEstorno($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verEstorno = new \App\adms\Models\helper\AdmsRead();
        $verEstorno->fullRead("SELECT es.*, lj.nome loja, f.nome func, fp.nome pag, b.nome bandeira, rp.nome resp, se.nome sit, m.nome motivo FROM adms_estornos es INNER JOIN tb_lojas lj ON lj.id=es.loja_id INNER JOIN tb_funcionarios f ON f.id=es.adms_func_id INNER JOIN tb_forma_pag fp ON fp.id=es.tb_forma_pag_id INNER JOIN adms_bandeiras b ON b.id=es.adms_bandeira_id INNER JOIN adms_resp_autorizacao rp ON rp.id=es.adms_resp_aut_id INNER JOIN adms_sits_estornos se ON se.id=es.adms_sits_est_id INNER JOIN adms_motivo_estorno m ON m.id=es.adms_mot_est_id WHERE es.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verEstorno->getResultado();
        return $this->Resultado;
    }

}
