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
     * <b>Ver Página:</b> Receber o id da página para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verEstorno($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPagina = new \App\adms\Models\helper\AdmsRead();
        $verPagina->fullRead("SELECT es.*
                FROM adms_estornos es
                WHERE es.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verPagina->getResultado();
        return $this->Resultado;
    }

}
