<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerDelivery {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verDelivery($DadosId) {
        
        $this->DadosId = (int) $DadosId;
        
        $verPed = new \App\adms\Models\helper\AdmsRead();
        $verPed->fullRead("SELECT d.*, l.nome loja, f.nome func, b.nome bairro, fp.nome forma, dl.nome sit
                FROM tb_delivery d
                INNER JOIN tb_lojas l ON l.id=d.loja_id
                INNER JOIN tb_funcionarios f ON f.id=d.func_id
                INNER JOIN tb_bairros b ON b.id=d.bairro_id
                INNER JOIN tb_forma_pag fp ON fp.id=d.forma_pag_id
                INNER JOIN tb_status_delivery dl ON dl.id=d.status_id
                WHERE d.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verPed->getResultado();
        return $this->Resultado;
    }

}
